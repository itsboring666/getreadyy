@extends('layouts.front')
@section('title', 'Manifesto | GET READY')

@section('content')

<section class="gr-editorial" style="padding: 100px 24px; min-height: 80vh;">
    <div class="gr-editorial-inner" style="grid-template-columns: 1fr; text-align: center; max-width: 800px; margin: 0 auto;">
        <div class="gr-editorial-text" style="align-items: center;">
            <div class="gr-editorial-label" style="justify-content: center;">THE MANIFESTO</div>
            <h1 class="gr-editorial-heading" style="font-size: clamp(40px, 6vw, 80px); margin: 24px 0;">
                CLOTHING FOR<br>
                <em>the journey</em>.
            </h1>
            <p class="gr-editorial-body" style="font-size: 20px; line-height: 1.6; max-width: 600px; margin: 0 auto 32px;">
                We started GET READY in 2004 with a simple belief: menswear should be built to last, designed without compromise, and worn until it falls apart.
            </p>
            <p class="gr-editorial-body-regular" style="max-width: 600px; margin: 0 auto 24px; text-align: left;">
                In an era of fast fashion and disposable trends, we choose the hard way. We source the heaviest cottons, the stiffest raw denims, and the most rugged leathers. Our clothes aren't meant to be comfortable on day one. They are meant to be broken in by you, earning their fades and scars through your experiences.
            </p>
            <p class="gr-editorial-body-regular" style="max-width: 600px; margin: 0 auto 40px; text-align: left;">
                Every piece in our catalog is made in small batches. We don't do seasonal collections; we do permanent additions. When you buy from GET READY, you're not buying an outfit for the weekend. You're investing in a piece of equipment for the long haul.
            </p>
            <a href="{{ route('products.all') }}" class="gr-editorial-btn" style="margin: 0 auto;">SHOP THE COLLECTION →</a>
        </div>
    </div>
</section>

@endsection
