@php
use App\Http\Controllers\LocationController;
@endphp
@if (count($location) == 0)
    <tr>
        <td colspan="5" class="text-center">
            nothing to show.
        </td>
    </tr>
@else
    @foreach ($location as $loc)
    @php
    
        $data =LocationController::getLocationFromCoordinates($loc->last_lang,$loc->last_long,);
    @endphp
        <tr>
            <td>{{ $loc->name }}</td>
            <td>{{ $loc->created_at != null ? date('d-M-Y H:i:s', strtotime($loc->created_at)) : 'NA' }}</td>
            <td>{{$data}}</td>
        </tr>
    @endforeach
    <tr>
        <td colspan="4">
            {{ $location->links() }}
        </td>
    </tr>

@endif
