@extends('layouts.admin')

@section('title', 'Détails du Message')

@section('content')
    <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 2rem;">
        <h1 style="margin: 0;">Message Client</h1>
        <a href="{{ route('admin.messages.index') }}" class="btn btn-outline btn-sm">&larr; Retour</a>
    </div>

    <div style="background: #fff; border-radius: 20px; padding: 2.5rem; border: 1px solid rgba(0,0,0,0.05); box-shadow: 0 4px 20px rgba(0,0,0,0.02);">
        <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 2rem; border-bottom: 1px solid var(--border); padding-bottom: 1.5rem;">
            <div>
                <h2 style="margin: 0 0 0.5rem; font-size: 1.5rem; font-weight: 800;">{{ $message->subject }}</h2>
                <div style="color: var(--text-muted); font-size: 0.95rem;">
                    Expéditeur: <strong style="color: var(--text);">{{ $message->name }}</strong> (<a href="mailto:{{ $message->email }}">{{ $message->email }}</a>)
                </div>
            </div>
            <div style="text-align: right;">
                <span class="badge" style="background: var(--bg); color: var(--text-muted);">
                    Le {{ $message->created_at->format('d M Y à H:i') }}
                </span>
            </div>
        </div>

        <div style="font-size: 1.05rem; line-height: 1.8; color: var(--text); background: #f8fafc; padding: 1.75rem; border-radius: 12px; white-space: pre-wrap;">{{ $message->message }}</div>

        <div style="margin-top: 2.5rem; display: flex; gap: 1rem;">
            <a href="mailto:{{ $message->email }}?subject=Re: {{ urlencode($message->subject) }}" class="btn btn-primary">
                <i class="fas fa-reply" style="margin-right:0.5rem;"></i> Répondre par Email
            </a>
            
            <form action="{{ route('admin.messages.destroy', $message) }}" method="post" onsubmit="return confirm('Vraiment supprimer ce message ?');">
                @csrf
                @method('delete')
                <button type="submit" class="btn btn-outline" style="border-color:#dc3545; color:#dc3545;">
                    <i class="fas fa-trash" style="margin-right:0.5rem;"></i> Supprimer
                </button>
            </form>
        </div>
    </div>
@endsection
