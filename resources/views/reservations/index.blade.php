@extends('layouts.app')

@section('content')
    <div class="main-content-inner wrap-dashboard-content">
        <div class="button-show-hid show-m">
            <span class="body-1">Affichage des réservations</span>
        </div>
        <div class="row">
            
        </div>
        <div class="widget-box-2 wd-listing">
            <div class="row align-items-start justify-content-start">
                <div class="flat-bt-top col-md-12">
                    <h6 class="title">{{ count($reservations) }} Reservations</h6>
                </div>
            </div>
             
            <div class="wrap-table">
                <div class="table-responsive">
                    <table>
                        <thead>
                            <tr>
                                <th>Client</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Bien reserve</th>
                                <th>Crée le</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($reservations as $reservation)
                                <tr class="file-delete">
                                    <td>
                                        <span>{{ $reservation->nom ?? '' }} {{ $reservation->prenoms ?? '' }}</span>
                                    </td>
                                    <td>
                                        <span>{{ $reservation->email ?? '' }}</span>
                                    </td>
                                    <td>
                                        <span>{{ $reservation->phone ?? '' }}</span>
                                    </td>
                                    <td>
                                        <span>{{ $reservation->room_id ?? '' }}</span>
                                    </td>
                                    <td>
                                        <span>{{ $reservation->created_at->format('d/M/Y') ?? '' }}</span>
                                    </td>
                                    <td>
                                        <ul class="list-action d-flex align-items-center justify-content-center">
                                            <li class="border rounded me-2" data-bs-target="#showReservationModal{{ $reservation->id }}" data-bs-toggle="modal">
                                                <a class="item p-2" href="javascript:void(0);"><i class="icon icon-eye"></i></a>
                                            </li>
                                            <li class="border rounded me-2"><a class="item p-2"><i class="icon icon-trash"></i></a></li>
                                        </ul>
                                    </td>
                                </tr>

                                @include('reservations.showModal' , ['reservation' => $reservation])

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
