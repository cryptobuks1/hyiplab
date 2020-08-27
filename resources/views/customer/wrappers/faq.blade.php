@foreach(\App\Models\Faq::orderBy('created_at', 'desc')->limit(12)->get() as $faq)
    <div class="col-lg-6">
        <div class="card index3_card">

            <div class="card_pagee" role="tab" id="heading{{ $faq->id }}">
                <h5 class="h5-md">
                    <a class="{{ $loop->index > 0 ? 'collapsed' : '' }}" data-toggle="collapse" href="#collapse{{ $faq->id }}" role="button" aria-expanded="false" aria-controls="collapse{{ $faq->id }}">
                        {{ $faq->question }}
                    </a>
                </h5>
            </div>

            <div id="collapse{{ $faq->id }}" class="collapse {{ $loop->index == 0 ? 'show' : '' }}" role="tabpanel" aria-labelledby="heading{{ $faq->id }}" data-parent="#accordion" style="">
                <div class="card-body">
                    <div class="card_cntnt">
                        <p>{{ $faq->answer }}</p>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endforeach