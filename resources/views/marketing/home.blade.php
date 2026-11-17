@extends('layouts.marketing')
@section('title', 'AI Law Firm Intake & Document Agent | LexIntake AI')
@section('content')
<section class="hero">
    <span class="badge">Legal tech · Navy #1E3A8A</span>
    <h1>AI Law Firm Intake & Document Agent</h1>
    <p>Conflict checks, matter intake, contract drafting assistance, and secure client document workflows — modular so your firm only runs what it needs.</p>
    <div class="cta">
        <a class="btn" href="{{ route('demo') }}">Try the demo</a>
        <a class="btn ghost" href="{{ route('features') }}">Explore features</a>
    </div>
</section>
<section class="grid">
    @foreach($modules as $key => $module)
        <article class="card">
            <span class="badge">{{ ($module['enabled'] ?? false) ? 'Enabled' : 'Optional' }}</span>
            <h3>{{ $module['label'] }}</h3>
            <p>{{ $module['description'] }}</p>
        </article>
    @endforeach
</section>
@endsection