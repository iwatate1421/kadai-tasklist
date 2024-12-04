@if (Auth::id() == $user->id)
    <div class="mt-4">
        <form method="POST" action="{{ route('tasks.store') }}">
            @csrf
            
            <div class="form-control my-4">
                <label for="status" class="label">
                    <span class="label-text">ステータス:</span>
                </label>
                <input type="text" name="status" class="input input-bordered w-full">
            </div>
            <div class="form-control my-4">
                <label for="content" class="label">
                    <span class="label-text">タスク内容:</span>
                </label>
                <input type="text" name="content" class="input input-bordered w-full">
            </div>        
            <button type="submit" class="btn btn-primary btn-block normal-case">タスクを登録します</button>
        </form>
    </div>
@endif