<table class="table table-striped table-hover">
  <thead>
    <tr>
      <th scope="col">Naziv Fajla</th>
      <th scope="col">Upload Datum</th>
      <th scope="col">Prikaži Originalni Fajl</th>
      <th scope="col">Prikaži Potpisani Fajl</th>
    </tr>
  </thead>
  <tbody>
  	@forelse ($data as $v)
        <tr>
          <td>{{ $v['title'] }}</td>
          <td>{{ \Carbon\Carbon::parse($v['time'])->format('d/m/Y @ G:i:s')}}</td>
          <td><a href="{{ route('pdf.view', [$v['basename'], 'original']) }}" class="btn btn-light"><i class="bi bi-download"></i></a></td>
          <td><a href="{{ route('pdf.view', [$v['basename'], 'signed']) }}" class="btn btn-light"><i class="bi bi-download"></i></a></td>
        </tr>
    @empty
    
    @endforelse
  </tbody>
</table>