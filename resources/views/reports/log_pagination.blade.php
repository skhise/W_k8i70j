@if (count($systemlogs) == 0)
    <tr>
        <td colspan="11" class="text-center">
            no log found.
        </td>
    </tr>
@else
    @foreach ($systemlogs as $systemlog)
        <tr>
            <td>{{ $systemlog->name }}</td>
            <td>{{ $systemlog->ActionDescription }}</td>
            <td>{{ $systemlog->created_at }}</td>
        </tr>
    @endforeach
    <tr>
        <td colspan="11">
            {{ $systemlogs->links() }}
        </td>
    </tr>

@endif
