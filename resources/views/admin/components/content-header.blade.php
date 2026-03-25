
@if(!isset($content_header))
TODO 未実装！！
@else 
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-md-6">
            </div>
            <div class="col-md-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ url('system') }}">Home</a></li>
                    @foreach ($content_header['breadcrumb'] as $breadcrumb)
                        @empty($breadcrumb['url'])
                            <li class="breadcrumb-item active">{{ $breadcrumb['title'] }}</li>
                        @else
                            <li class="breadcrumb-item"><a href="{{ $breadcrumb['url'] }}">{{ $breadcrumb['title'] }}</a>
                            </li>
                        @endempty
                    @endforeach
                </ol>
            </div>
        </div>
    </div><!-- /.container-fluid -->
</section>

@endif