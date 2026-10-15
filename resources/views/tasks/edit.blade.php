
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Edit Task</title>
    <link rel="stylesheet"
          href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
</head>
<body class="bg-light">

<div class="container py-5">
    <div class="card mx-auto" style="max-width: 700px;">
        <div class="card-header bg-info text-white">
            <h4 class="mb-0">Edit Task</h4>
        </div>

        <div class="card-body">
            @if($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('tasks.update', $task) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label for="title">Task Title *</label>
                    <input type="text" id="title" name="title"
                           class="form-control @error('title') is-invalid @enderror"
                           value="{{ old('title', $task->title) }}" required>
                    @error('title')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="description">Description (Optional)</label>
                    <textarea id="description" name="description"
                              class="form-control" rows="4">{{ old('description', $task->description) }}</textarea>
                </div>

                <div class="form-group">
                    <label for="status">Status *</label>
                    <select id="status" name="status" class="form-control" required>
                        <option value="Pending"
                            {{ old('status', $task->status) === 'Pending' ? 'selected' : '' }}>
                            Pending
                        </option>
                        <option value="Completed"
                            {{ old('status', $task->status) === 'Completed' ? 'selected' : '' }}>
                            Completed
                        </option>
                    </select>
                </div>

                <button type="submit" class="btn btn-info">
                    Update Task
                </button>
                <a href="{{ route('tasks.index') }}" class="btn btn-secondary">
                    Cancel
                </a>
            </form>
        </div>
    </div>
</div>

</body>
</h