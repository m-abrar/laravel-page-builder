@php
    use App\Models\Testimonial;
    $testimonials = Testimonial::where('status', 1)->latest()->limit(3)->get();
@endphp

@if ($testimonials->isNotEmpty())
    <style>
        .testimonial-widget {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            justify-content: center;
            padding: 20px;
            background-color: #f9f9f9;
            border-radius: 10px;
        }
        .testimonial-item {
            width: 300px;
            background: white;
            padding: 15px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            text-align: center;
        }
        .testimonial-image {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            object-fit: cover;
            margin-bottom: 10px;
        }
        .testimonial-item p {
            font-style: italic;
            color: #555;
        }
        .testimonial-item strong {
            display: block;
            margin-top: 10px;
            font-weight: bold;
            color: #333;
        }
        .testimonial-rating {
            margin-top: 5px;
            font-size: 14px;
            color: #f39c12;
        }
    </style>

    <div class="testimonial-widget">
        @foreach ($testimonials as $testimonial)
            <div class="testimonial-item">
                <img src="{{ asset($testimonial->image) }}" alt="{{ $testimonial->name }}" class="testimonial-image">
                <p>"{{ $testimonial->message }}"</p>
                <strong>- {{ $testimonial->name }}, {{ $testimonial->designation }}</strong>
                <div class="testimonial-rating">
                    ⭐ {{ $testimonial->rating }}/5
                </div>
            </div>
        @endforeach
    </div>
@endif
