@extends('layouts.app')

@section('content')
    <div class="main-content-inner wrap-dashboard-content">
        <div class="button-show-hide show-mb">
            <span class="body-1">Afficher le tableau de bord</span>
        </div>
        <div class="row">
            <div class="col-md-3">
                <fieldset class="box-fieldset">
                    <label for="title">
                        Post Status:<span>*</span>
                    </label>
                    <div class="nice-select" tabindex="0"><span class="current">Select</span>
                        <ul class="list">
                            <li data-value="1" class="option selected">Select</li>
                            <li data-value="2" class="option">Publish</li>
                            <li data-value="3" class="option">Pending</li>
                            <li data-value="3" class="option">Hidden</li>
                            <li data-value="3" class="option">Sold</li>
                        </ul>
                    </div>
                </fieldset>
            </div>
            <div class="col-md-9">
                <fieldset class="box-fieldset">
                    <label for="title">
                        Post Status:<span>*</span>
                    </label>
                    <input type="text" class="form-control style-1" placeholder="Search by title">
                </fieldset>
            </div>
        </div>
        <div class="widget-box-2 wd-listing">
            <div class="row align-items-center justify-content-center">
                <div class="flat-bt-top col-md-9">
                    <h6 class="title">My Properties</h6>
                </div>
                <div class="flat-bt-top col-md-3 text-end">
                    <a class="tf-btn primary" href="{{ route('partner.properties.create') }}"><i class="icon icon-plus"></i> Ajouter une propriété</a>
                </div>
            </div>
             
            <div class="wrap-table">
                <div class="table-responsive">
                    <table>
                        <thead>
                            <tr>
                                <th>Titre</th>
                                <th>Date de création</th>
                                <th>Status</th>
                                <th>Feature</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($properties as $property)
                                <tr class="file-delete">
                                    <td>
                                        <div class="listing-box">
                                            <div class="images">
                                                <img src="{{ asset('media/properties'.$property->property_code .'/'.$property->image_property)}}" alt="images">
                                            </div>
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
                                        <span>No</span>
                                    </td>
                                    <td>
                                        <ul class="list-action d-flex align-items-center justify-content-center">
                                            <li class="border rounded me-2"><a class="item p-2"><i class="icon icon-edit"></i></a></li>
                                            <li class="border rounded me-2"><a class="item p-2" href="{{ route('partner.properties.show', $property->property_code) }}"><i class="icon icon-eye"></i></a></li>
                                            <li class="border rounded me-2"><a class="item p-2"><i class="icon icon-trash"></i></a></li>
                                        </ul>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <ul class="wd-navigation">
                    <li><a href="#" class="nav-item active">1</a></li>
                    <li><a href="#" class="nav-item">2</a></li>
                    <li><a href="#" class="nav-item">3</a></li>
                    <li><a href="#" class="nav-item"><i class="icon icon-arr-r"></i></a></li>
                </ul>
            </div>
        </div>
    </div>
@endsection
