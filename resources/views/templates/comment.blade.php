<tr>
  <td>
    <a href="{{url('/' . $Comment->Profile->User->username)}}">
    &#64;{{$Comment->Profile->User->username}}
    </a>
    {{$Comment->comment}} <br> Like | Report
  </td>
</tr>
