@extends('layouts.marketing')
@section('title', 'Toggleable Modules | LexIntake AI')
@section('content')
<h2 class="section-title">Run only the modules your firm needs</h2>
<p style="color:var(--muted);">Every module can be enabled or disabled via config, environment flags, or the Modules Filament resource.</p>
<section class="grid">
@foreach($modules as $key => $module)
<article class="card">
    <span class="badge">{{ $key }}</span>
    <h3>{{ $module['label'] }}</h3>
    <p>{{ $module['description'] }}</p>
    <p><strong>Status:</strong> {{ ($module['enabled'] ?? false) ? 'ON' : 'OFF' }}</p>
</article>
@endforeach
</section>
@endsection