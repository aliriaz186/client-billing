@extends('layouts.app')
@section('content')
    <div class="p-4 ml-3" style="margin-left: 20px">
        <div class="row">
            <div class="col-md-8 mt-2">
                <h2>My Packages History</h2>
            </div>
        </div>
    </div>
    <div class="px-5" style="margin-left: 20px">
        <table class="table">
            <thead>
            <tr>
                <th>#</th>
                <th class="text-center">Package</th>
                <th class="text-center">Amount</th>
                <th class="text-center">Status</th>
            </tr>
            </thead>
            <tbody>
            @if(count($packages) != 0)
                @foreach($packages as $key => $package)
                    <tr>
                        <td>{{$key + 1}}</td>
                        @if($package->package == 1)
                            <td class="text-center">5-10 Hours</td>
                        @else
                            <td class="text-center">40 hours a week for 3 months</td>
                        @endif
                        <td class="text-center">$100/hr</td>
                        <td class="text-center">{{$package->status}}</td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    {{--                    <td></td>--}}
                    <td>No Data Found!</td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
            @endif
            </tbody>
        </table>
    </div>
@endsection
