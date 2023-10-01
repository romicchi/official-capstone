<table class="table">
    <thead>
        <tr>
            <th class="th-color">Period</th>
            <th class="th-color">Number of Users</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($reportData as $period => $userCount)
            <tr>
                <td>{{ $period }}</td>
                <td>{{ $userCount }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
