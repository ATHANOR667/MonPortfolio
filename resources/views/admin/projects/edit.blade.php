@extends('layouts.admin')

@section('title', 'Modifier un projet')

@section('admin-content')
    @livewire('edit-project', ['project' => $project])
@endsection