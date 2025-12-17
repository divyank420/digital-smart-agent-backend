<!DOCTYPE html>
<html>
<body> 
    <table>
        <tbody>
            @foreach ($data as $key => $value)
            @if ($key % 4 == 0)
            <tr>
                @endif
                <td>
                    <div style="width:150px;margin:30px 15px;text-align: center;border:1px solid">
                        <img src="{{asset('public/rm/qrcodes/'.$value['qr_code'])}}" style="width:150px;height:150px" alt="...">
                        <div style="text-align: center;padding:10px 5px">{{$value['name']}}</div>
                    </div>
                </td>
                @if($key % 4 == 3)
            </tr>
            @endif
            @endforeach
        </tbody>
    </table>
</body>
</html>