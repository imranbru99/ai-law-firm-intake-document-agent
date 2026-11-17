@extends('layouts.marketing')
@section('title', 'Client Portal | LexIntake AI')
@section('content')
<h2 class="section-title">Your matters</h2>
<section class="grid">
@forelse($matters as $matter)
<article class="card">
    <span class="badge">{{ $matter->matter_number }}</span>
    <h3>{{ $matter->title }}</h3>
    <p>Status: {{ $matter->status }} · Documents: {{ $matter->documents->count() }}</p>
</article>
@empty
<article class="card"><p>No portal matters linked to this account yet.</p></article>
@endforelse
</section>
<h2 class="section-title">Messages</h2>
<section class="grid">
@foreach($messages as $message)
<article class="card">
    <h3>{{ $message->subject }}</h3>
    <p>{{ $message->body }}</p>
</article>
@endforeach
</section>
@endsection