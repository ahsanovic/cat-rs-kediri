<div>
    <h4>Data Master SKB</h4>
    <div class="row mt-2">
        <div class="col-md-12">
            <ul class="nav nav-tabs">
                <li class="nav-item">
                  <a class="nav-link {{ Request::is('admin/rumpun') ? 'active' : '' }}" href="{{ route('rumpun') }}">Rumpun Jabatan</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link {{ Request::is('admin/jabatan') ? 'active' : '' }}" href="{{ route('jabatan') }}">Jabatan</a>
                </li>
            </ul>
        </div>
    </div>
</div>
