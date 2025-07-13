@extends('layouts.app')

@section('content')
    <div class="main-content-inner">
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