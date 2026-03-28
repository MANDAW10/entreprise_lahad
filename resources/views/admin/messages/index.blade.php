@extends('layouts.admin')

@section('title', 'Boîte de Réception')

@section('content')
    <h1 style="margin-bottom: 2rem;">Boîte de Réception</h1>

    <div class="table-responsive">
        <table class="table">
        <thead>
            <tr>
                <th>Statut</th>
                <th>Reçu le</th>
                <th>Expéditeur</th>
                <th>Sujet</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($messages as $msg)
                <tr style="{{ $msg->is_read ? 'opacity: 0.8;' : 'font-weight: 600;' }}">
                    <td>
                        @if($msg->is_read)
                            <span class="badge" style="background: #e2e8f0; color: #64748b;">Lu</span>
                        @else
                            <span class="badge badge-warning">Nouveau</span>
                        @endif
                    </td>
                    <td>{{ $msg->created_at->format('d/m/Y H:i') }}</td>
                    <td>
                        {{ $msg->name }}<br>
                        <small style="color: var(--text-muted);">{{ $msg->email }}</small>
                    </td>
                    <td>{{ \Illuminate\Support\Str::limit($msg->subject, 40) }}</td>
                    <td>
                        <a href="{{ route('admin.messages.show', $msg) }}" class="btn btn-sm btn-outline"><i class="fas fa-eye"></i></a>
                        <form action="{{ route('admin.messages.destroy', $msg) }}" method="post" style="display:inline;" onsubmit="return confirm('Vraiment supprimer ce message ?');">
                            @csrf
                            @method('delete')
                            <button type="submit" class="btn btn-sm btn-outline" style="border-color:#dc3545; color:#dc3545;"><i class="fas fa-trash"></i></button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" style="text-align: center; padding: 3rem; color: var(--text-muted);">Aucun message reçu pour le moment.</td>
                </tr>
            @endforelse
        </tbody>
        </table>
    </div>
    
    <div style="margin-top: 1.5rem;">
        {{ $messages->links() }}
    </div>
@endsection
