@extends('layouts.marketing')
@section('title', 'Demo Access | LexIntake AI')
@section('content')
<h2 class="section-title">Demo credentials</h2>
<section class="grid">
<article class="card">
    <h3>Admin / Demo user</h3>
    <p>Email: <strong>demo@lexintake.test</strong></p>
    <p>Password: <strong>password</strong></p>
    <p style="margin-top:1rem;"><a class="btn" href="/admin">Open Filament admin</a></p>
</article>
<article class="card">
    <h3>Client portal user</h3>
    <p>Email: <strong>client@lexintake.test</strong></p>
    <p>Password: <strong>password</strong></p>
    <p>Use the portal route after login to review matter status.</p>
</article>
</section>
@endsection