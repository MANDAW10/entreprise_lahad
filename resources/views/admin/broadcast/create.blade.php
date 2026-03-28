@extends('layouts.admin')
@section('title', 'Diffuser une Notification')

@section('content')
<div style="background: #fff; border-radius: 20px; padding: 2.5rem; border: 1px solid rgba(0,0,0,0.05); box-shadow: 0 4px 20px rgba(0,0,0,0.02); max-width: 650px;">
    <h1 style="margin-top: 0; margin-bottom: 0.5rem; font-size: 1.6rem;">📢 Envoyer une Notification</h1>
    <p style="color: var(--text-muted); margin-bottom: 2rem;">Rédigez un message qui apparaîtra instantanément dans la cloche de notification de vos clients (en français).</p>

    <form action="{{ route('admin.broadcast.store') }}" method="post">
        @csrf
        <div class="form-group" style="margin-bottom: 1.5rem;">
            <label style="font-weight: 700; color: var(--text); margin-bottom: 0.5rem; display: block;">Titre de l'alerte</label>
            <input type="text" name="title" class="form-control" style="background:#f8fafc; border:1px solid #e2e8f0; padding:0.9rem 1.25rem; border-radius:12px; width:100%; transition:all 0.3s;" placeholder="Ex: Grosse Promo du Weekend !" required>
        </div>

        <div class="form-group" style="margin-bottom: 1.5rem;">
            <label style="font-weight: 700; color: var(--text); margin-bottom: 0.5rem; display: block;">Message (Contenu)</label>
            <textarea name="message" class="form-control" style="background:#f8fafc; border:1px solid #e2e8f0; padding:1.25rem; border-radius:12px; width:100%; min-height:120px; transition:all 0.3s;" placeholder="Ex: Profitez de -20% sur la viande de caille locale en nous appelant dès aujourd'hui..." required></textarea>
        </div>

        <div class="form-group" style="margin-bottom: 2.5rem;">
            <label style="font-weight: 700; color: var(--text); margin-bottom: 0.5rem; display: block;">Cible</label>
            <select name="target" class="form-control" style="background:#f8fafc; border:1px solid #e2e8f0; padding:0.9rem 1.25rem; border-radius:12px; width:100%;" required>
                <option value="all">Tous les clients inscrits</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary" style="padding: 1rem 2rem; border-radius: 12px; font-weight: 700; font-size: 1.1rem; width: 100%;">
            <i class="fas fa-paper-plane" style="margin-right:0.5rem;"></i> Envoyer la Notification
        </button>
    </form>
</div>
<style>
    .form-control:focus { background: #fff !important; border-color: var(--orange) !important; box-shadow: 0 0 0 4px rgba(232, 93, 4, 0.1) !important; outline: none; }
</style>
@endsection
