@extends('layouts.app')

@section('content')
    <div class="main-content-inner">
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fermer"></button>
            </div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fermer"></button>
            </div>
        @endif
        <form action="{{ route('admin.import.city.country') }}" method="post" enctype="multipart/form-data">
            @csrf
            <input type="file" name="file" class="form-control" required>
            @error('file')
                <span class="text-danger">{{ $message }}</span>
            @enderror
            <button type="submit" class="btn btn-primary">Importer</button>
        </form>
        <div class="button-show-hid ">
            <span class="body-1">Liste des partenaires</span>
        </div>
        <div class="flat-counter-v2 tf-counter">
            
            <h6 class="numbe" >{{ count($partners) }} /Partenaires</h6>
        </div>
        <div class="wrapper-content">
            <div class="table-responsive table">
                <div class="wrap-table">
                        <div class="table-responsive">

                            <table>
                                <thead>
                                    <tr>
                                        <th>Company</th>
                                        <th>Corespondant</th>
                                        <th>Email</th>
                                        <th>Phone</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($partners as $partner)
                                        
                                    
                                    <tr class="file-delete">
                                        <td>
                                           {{ $partner->company ?? 'N/A' }}
                                        </td>
                                        <td>
                                            {{ $partner->name ?? '' }} {{ $partner->lastname ?? '' }}
                                        </td>
                                        <td>
                                            {{ $partner->email ?? '' }}
                                        </td>
                                        <td>
                                            {{ $partner->phone ?? '' }}
                                        </td>
                                        <td>
                                            {{-- <ul class="list-action row">
                                                <li><a class="item"><i class="icon icon-edit"></i>Edit</a></li>
                                                <li><a class="item"><i class="icon icon-sold"></i>Sold</a></li>
                                                <li><a class="remove-file item"><i class="icon icon-trash"></i>Delete</a>
                                                </li>
                                            </ul> --}}
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
            </div>
        </div>
    </div>
@endsection