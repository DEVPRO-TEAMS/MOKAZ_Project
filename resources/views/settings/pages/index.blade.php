@extends('layouts.app')

@section('content')
<div class="container">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb bg-white p-2 rounded shadow-sm">
            <li class="breadcrumb-item"><a href="{{ url('/') }}">Accueil</a></li>
            <li class="breadcrumb-item active" aria-current="page">Liste des variables</li>
        </ol>
    </nav>

    <!-- Filtres -->
    <form method="GET" class="mb-4">
        <div class="row g-2">
            <div class="col-md-3">
                <input type="text" name="keyword" class="form-control" placeholder="Mot-clé" value="{{ request('keyword') }}">
            </div>
            <div class="col-md-2">
                <input type="text" name="code" class="form-control" placeholder="Code" value="{{ request('code') }}">
            </div>
            <div class="col-md-3">
                <input type="text" name="type" class="form-control" placeholder="Type" value="{{ request('type') }}">
            </div>
            <div class="col-md-3">
                <input type="text" name="category" class="form-control" placeholder="Catégorie" value="{{ request('category') }}">
            </div>
            <div class="col-md-1">
                <button type="submit" class="btn btn-primary w-100">Filtrer</button>
            </div>
        </div>
    </form>

    <!-- Tableau -->
    <div class="card">
        <div class="card-header bg-white">
            <h5 class="mb-0">Liste des variables</h5>
        </div>
        <div class="table-responsive">
            <table class="table table-striped align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Code</th>
                        <th>Libellé</th>
                        <th>Description</th>
                        <th>Type</th>
                        <th>Catégorie</th>
                        <th>État</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($variables as $variable)
                        <tr>
                            <td>{{ $variable->code ?? '' }}</td>
                            <td>{{ $variable->libelle ?? '' }}</td>
                            <td>{{ Str::limit($variable->description, 50) ?? '' }}</td>
                            <td>{{ $variable->type ?? '' }}</td>
                            <td>{{ $variable->category ?? '' }}</td>
                            <td>
                                @if ($variable->etat == 'actif')
                                    <span class="text-light badge bg-success"><i class="bi bi-check-circle"></i>Actif</span>
                                @else
                                    <span class="text-light badge bg-danger"><i class="bi bi-check-circle"></i> Inactif</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center">Aucune variable trouvée.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection


