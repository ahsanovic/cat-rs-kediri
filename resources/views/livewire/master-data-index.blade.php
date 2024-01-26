<div>
    <h4>Data Master SKD</h4>
    <div class="row mt-2">
        <div class="col-md-12">
            <ul class="nav nav-tabs">
                <li class="nav-item">
                  <a class="nav-link {{ Request::is('admin/jenis-soal') ? 'active' : '' }}" href="{{ route('jenis-soal') }}">Jenis Soal</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link {{ Request::is('admin/bidang') ? 'active' : '' }}" href="{{ route('bidang') }}">Bidang</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ Request::is('admin/subbidang') ? 'active' : '' }}" href="{{ route('subbidang') }}">Sub Bidang</a>
                </li>
              </ul>
        </div>
    </div>
</div>
