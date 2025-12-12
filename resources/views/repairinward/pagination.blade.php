@php
    $repairInwards = $repairInwards ?? collect();
    $hasRecords = $repairInwards->count() > 0;
@endphp

@unless ($hasRecords)
    <tr>
        <td colspan="6" class="text-center">No defective items found</td>
    </tr>
@endunless

@if ($hasRecords)
    @foreach ($repairInwards as $repairInward)
        <tr>
            <td>{{ $repairInward->defective_no }}</td>
            <td>
                <i class="far fa-calendar-alt"></i>
                {{ $repairInward->defective_date ? date('d M Y', strtotime($repairInward->defective_date)) : 'N/A' }}
            </td>
            <td>{{ $repairInward->CST_Name ?? 'N/A' }}</td>
            <td>{{ $repairInward->part_model_name ?? 'N/A' }}</td>
            <td>{{ $repairInward->ticket_no ?? 'N/A' }}</td>
            <td>
                <div class="d-flex align-items-center">
                    <span class="badge badge-{{ $repairInward->repairStatus && $repairInward->repairStatus->id == 1 ? 'primary' : 'success' }} mr-2">
                        {{ $repairInward->repairStatus->status_name ?? 'N/A' }}
                    </span>
                    <a href="{{ route('repairinwards.show', $repairInward->id) }}" class="btn btn-sm btn-info mr-1" title="View">
                        <i class="far fa-file-alt"></i>
                    </a>
                    <a href="{{ route('repairinwards.edit', $repairInward->id) }}" class="btn btn-sm btn-warning mr-1" title="Edit">
                        <i class="fas fa-sync-alt"></i>
                    </a>
                    <form action="{{ route('repairinwards.destroy', $repairInward->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this repair inward?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger" title="Delete">
                            <i class="fa fa-trash"></i>
                        </button>
                    </form>
                </div>
            </td>
        </tr>
    @endforeach
@endif

@if ($hasRecords && $repairInwards->hasPages())
    <tr>
        <td colspan="6">
            {{ $repairInwards->links() }}
        </td>
    </tr>
@endif

