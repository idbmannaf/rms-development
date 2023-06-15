<table>
    <thead>
    <tr>
        @foreach($users->first()->getAttributes() as $key => $value)
            <th>{{  Str::title(str_replace("_", " ", $key)) }}</th>
        @endforeach
    </tr>
    </thead>
    <tbody>
    @foreach($users as $user)
{{--        {{dd($user)}}--}}
        <tr>
            @foreach($user as $value)
                <td>{{ $value }}</td>
            @endforeach
        </tr>
    @endforeach
    </tbody>
</table>
