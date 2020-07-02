@extends('layouts.web')

@section('title', "Tous les utilisateurs || e-earners")

@section('breadtitle', "Tous les utilisateurs")

@section('breadli')
<li class="breadcrumb-item active">Tous les utilisateurs</li>               
@endsection

@section('content')
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Tous les utilisateurs</h4>
            <div class="table-responsive m-t-40">
                <table id="myTable" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>nom d'utilisateur</th>
                            <th>Rejoint</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach ($users as $user)
                        <tr>
                            <td>{{$user->name}}</td>
                            <td>{{$user->email}}</td>
                            <td>{{$user->username}}</td>
                            <td>{{$user->created_at}}</td>
                            <td>
                                @if ($user->activated == 'yes')
                                    <span class="text-success">activé</span>
                                @else
                                    <span class="text-danger">non activé</span>
                                @endif
                            </td>
                            <td>
                                @if ($user->id !== Auth::id())
                                    <a href="/delete-user/{{$user->id}}" class="btn btn-danger btn-sm">Supprimer</a>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
