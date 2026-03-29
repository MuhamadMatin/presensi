@extends('errors::layout')

@section('title', __('Payment Required'))
@section('code', '402')
@section('message', __($exception->getMessage() ?? 'Payment Required'))
