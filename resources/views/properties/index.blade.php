@extends('layouts.app')

@section('content')
    <div class="main-content-inne wrap-dashboard-content">
        <div class="button-show-hide show-mb">
            <span class="body-1">Afficher le tableau de bord</span>
        </div>
        <div class="row">
            <div class="col-md-3">
                <fieldset class="box-fieldset">
                    <label for="title">
                        Status:<span>*</span>
                    </label>
                    <select name="status" class="nice-select list style-1" id="">
                        <option value="" selected>Choisir</option>
                        <option value="Pending">En attente</option>
                        <option value="Published">Publier</option>
                        <option value="Unpublished">Non publier</option>
                    </select>
                    
                </fieldset>
            </div>
            
        </div>
        <div class="widget-box-2 wd-listing">
            <div class="row align-items-center justify-content-center">
                <div class="flat-bt-top col-md-9">
                    <h6 class="title">Mes Properties</h6>
                </div>
                <div class="flat-bt-top col-md-3 text-end">
                    <a class="tf-btn primary" href="{{ route('partner.properties.create') }}"><i class="icon icon-plus"></i> Ajouter une propriété</a>
                </div>
            </div>
             
            <div class="wrap-table">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0" id="example">
                        <thead>
                            <tr>
                                <th>Image</th>
                                <th>Titre</th>
                                <th>Date de création</th>
                                <th>Status</th>
                                <th>Nombre d'appartements</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            
                            @foreach ($properties as $property)
                                <tr class="file-delete">
                                    <td>
                                        <div class="listing-box">
                                            <div class="images">
                                                <img src="{{ asset('media/properties_'.$property->property_code .'/'.$property->image_property) }}" alt="images">
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="listing-box">
                                            
                                            <div class="content">
                                                <div class="title"><a href="property-details-v1.html" class="link"> {{ $property->title}} </a> </div>
                                                <div class="text-date"> {{ $property->address}} </div>
                                                {{-- <div class="text-1 fw-7">$5050,00</div> --}}
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span>{{ $property->created_at->format('d-M-Y')}}</span>
                                    </td>
                                    <td>
                                        <div class="status-wrap">
                                            <a href="#" class="btn-status">{{ $property->etat}}</a>
                                        </div>
                                    </td>
                                    <td>
                                        <span>{{ $property->appartements->count()}}</span>
                                    </td>
                                    <td>
                                        <ul class="list-action d-flex align-items-center justify-content-center">
                                            {{-- <li class="border rounded me-2"><a class="item p-2"><i class="icon icon-edit"></i></a></li> --}}
                                            <li class="border rounded me-2"><a class="item p-2" href="{{ route('partner.properties.show', $property->property_code) }}"><i class="icon icon-eye"></i></a></li>
                                            <li class="border rounded me-2"><a class="item p-2"><i class="icon icon-trash"></i></a></li>
                                        </ul>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                
            </div>
        </div>
    </div>
@endsection
