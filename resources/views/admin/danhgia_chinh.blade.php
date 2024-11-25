@extends('admin/layoutadmin')
@section('title') Sửa đánh giá @endsection
@section('noidungchinh')
<div class="container">
    <h1>Sửa Đánh giá</h1>

    <form action="{{ route('admin.reviews.update', $review->id) }}" method="POST">
        @csrf
        @method('POST')
        
        <div class="mb-3">
            <label for="rating" class="form-label">Đánh giá</label>
            <select name="rating" id="rating" class="form-control">
                <option value="0" {{ $review->rating == 0 ? 'selected' : '' }}>Tốt</option>
                <option value="1" {{ $review->rating == 1 ? 'selected' : '' }}>Trung bình</option>
                <option value="2" {{ $review->rating == 2 ? 'selected' : '' }}>Không tốt</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="comment" class="form-label">Nhận xét</label>
            <textarea name="comment" id="comment" rows="4" class="form-control">{{ $review->comment }}</textarea>
        </div>

        <button type="submit" class="btn btn-primary">Cập nhật</button>
    </form>
</div>
@endsection
