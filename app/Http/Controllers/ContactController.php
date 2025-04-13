<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Models\ContactReply;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Mail\ContactFormSubmission;
use App\Mail\ContactFormConfirmation;
use App\Mail\ContactReplyMail;
use Exception;

class ContactController extends Controller
{

    public function show(): \Illuminate\Contracts\View\View|RedirectResponse
    {
        try {
            return view('contact');
        } catch (Exception $e) {
            Log::error('Erreur lors de l\'affichage du formulaire de contact: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Une erreur est survenue lors de l\'affichage du formulaire de contact. Veuillez réessayer.');
        }
    }


    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|max:255',
                'subject' => 'required|string|max:255',
                'message' => 'required|string',
                'attachment' => 'nullable|file|max:5120',
            ]);

            // Handle file upload if present
            if ($request->hasFile('attachment')) {
                $path = $request->file('attachment')->store('contact_attachments', 'public');
                $validated['attachment'] = $path;
                $validated['attachment_name'] = $request->file('attachment')->getClientOriginalName();
            }

            $contact = Contact::create($validated);

            try {
                Mail::to(config('mail.admin_address', 'admin@example.com'))
                    ->queue(new ContactFormSubmission($contact));

                Mail::to($contact->email)
                    ->queue(new ContactFormConfirmation($contact));
            } catch (Exception $mailException) {
                Log::error('Erreur lors de l\'envoi des emails: ' . $mailException->getMessage());
            }

            return redirect()->back()->with('status', 'Votre message a été envoyé avec succès. Nous vous répondrons dans les plus brefs délais.');
        } catch (Exception $e) {
            Log::error('Erreur lors de l\'envoi du message de contact: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Une erreur est survenue lors de l\'envoi du message. Veuillez réessayer.')
                ->withInput();
        }
    }


    public function index(): \Illuminate\Contracts\View\View|RedirectResponse
    {
        try {
            $messages = Contact::latest()->paginate(15);
            return view('admin.contacts.index', compact('messages'));
        } catch (Exception $e) {
            Log::error('Erreur lors de l\'affichage des messages de contact: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Une erreur est survenue lors de l\'affichage des messages. Veuillez réessayer.');
        }
    }


    public function show_message(Contact $contact): \Illuminate\Contracts\View\View|RedirectResponse
    {
        try {
            if (!$contact->is_read) {
                $contact->update(['is_read' => true]);
            }

            $replies = $contact->replies()->orderBy('created_at', 'asc')->get();

            return view('admin.contacts.show', compact('contact', 'replies'));
        } catch (Exception $e) {
            Log::error('Erreur lors de l\'affichage du message de contact: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Une erreur est survenue lors de l\'affichage du message. Veuillez réessayer.');
        }
    }


    public function reply(Request $request, Contact $contact): RedirectResponse
    {
        try {
            $validated = $request->validate([
                'message' => 'required|string',
                'attachment' => 'nullable|file|max:5120',
            ]);

            if ($request->hasFile('attachment')) {
                $path = $request->file('attachment')->store('contact_replies', 'public');
                $validated['attachment'] = $path;
                $validated['attachment_name'] = $request->file('attachment')->getClientOriginalName();
            }

            $reply = new ContactReply([
                'contact_id' => $contact->id,
                'user_id' => Auth::guard('admin')->id(),
                'message' => $validated['message'],
                'attachment' => $validated['attachment'] ?? null,
                'attachment_name' => $validated['attachment_name'] ?? null,
            ]);

            $reply->save();

            $contact->update([
                'replied_at' => now(),
            ]);

            try {
                Mail::to($contact->email)
                    ->queue(new ContactReplyMail($contact, $reply));
            } catch (Exception $mailException) {

                Log::error('Erreur lors de l\'envoi de l\'email de réponse: ' . $mailException->getMessage());
            }

            return redirect()->route('admin.contacts.show', $contact)->with('status', 'Réponse envoyée avec succès.');
        } catch (Exception $e) {
            Log::error('Erreur lors de l\'envoi de la réponse: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Une erreur est survenue lors de l\'envoi de la réponse. Veuillez réessayer.')
                ->withInput();
        }
    }


    public function destroy(Contact $contact): RedirectResponse
    {
        try {
            if ($contact->attachment) {
                Storage::disk('public')->delete($contact->attachment);
            }

            foreach ($contact->replies as $reply) {
                if ($reply->attachment) {
                    Storage::disk('public')->delete($reply->attachment);
                }
                $reply->delete();
            }

            $contact->delete();

            return redirect()->route('admin.contacts.index')->with('status', 'Message supprimé avec succès.');
        } catch (Exception $e) {
            Log::error('Erreur lors de la suppression du message de contact: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Une erreur est survenue lors de la suppression du message. Veuillez réessayer.');
        }
    }


    public function markAsRead(Contact $contact): RedirectResponse
    {
        try {
            $contact->update(['is_read' => true]);

            return redirect()->back()->with('status', 'Message marqué comme lu.');
        } catch (Exception $e) {
            Log::error('Erreur lors du marquage du message comme lu: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Une erreur est survenue lors du marquage du message. Veuillez réessayer.');
        }
    }


    public function markAsUnread(Contact $contact): RedirectResponse
    {
        try {
            $contact->update(['is_read' => false]);

            return redirect()->back()->with('status', 'Message marqué comme non lu.');
        } catch (Exception $e) {
            Log::error('Erreur lors du marquage du message comme non lu: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Une erreur est survenue lors du marquage du message. Veuillez réessayer.');
        }
    }
}
