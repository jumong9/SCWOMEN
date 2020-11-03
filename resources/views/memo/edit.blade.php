@extends('memo._')

@section('title', 'Edit Memo #'.$memo->id.' - ')

@section('form')
@include('memo._form')
@endsection

@section('list')
@include('memo._form_toolbar')
@endsection
