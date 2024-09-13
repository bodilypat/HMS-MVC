@extends('layouts.app')
@section('content')
    <div id="admin-content">
        <div class="container">
            <div class="row">
                <div class="col-md-3"><h2 class="admin-heading">All Authors</h2></div>
                <div class="offset-md-7 col-md-2">
                    <a class="add-new" href="{{ route('authors.creat') }}">Add Author</a>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="message"></div>
                    <table class="content-table">
                        <thead>
                            <tr>
                                <th>S.No</th>
                                <th>Author Name</th>
                                <th>Edit</th>
                                <th>Delete</th>                                     
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                 <td>{{ $auther->id }}</td>
                                 <td>{{ $auther->name }}</td>
                                 <td class="edit"><a href="{{ route('auther.edit', $auther) }}" class="btn btn-success">Edit</a></td>
                                 <td class="Delete">delete
                                    <form action="{{ route('authors.destroy', $auther->id )}}" method="post" class="form-hidden">
                                        <button class="btn btn-danger delete-auther" >Delete</button>
                                        @csrf <!-- protect  application form CSRF attacks-->
                                    </form>
                                 </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4">No Authors Found</td>
                            </tr>
                            @endForelse
                        </tbody>
                    </table>
                    {{ $authirs->links('vendor/pagination/bootstrap-4') }}
                </div>
            </div>
        </div>
    </div>
@endsection
