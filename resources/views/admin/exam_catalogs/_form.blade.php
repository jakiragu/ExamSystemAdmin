<div class="grid grid-cols-1 md:grid-cols-2 gap-4">
    <div>
        <label class="block font-medium mb-1">Exam Code</label>
        <input type="text" name="exam_code" value="{{ old('exam_code', $examCatalog->exam_code ?? '') }}"
            class="w-full border-gray-300 rounded px-3 py-2 shadow-sm focus:outline-none focus:ring focus:ring-blue-300">
        @error('exam_code')<div class="text-red-500 text-sm mt-1">{{ $message }}</div>@enderror
    </div>

    <div>
        <label class="block font-medium mb-1">Exam Title</label>
        <input type="text" name="exam_title" value="{{ old('exam_title', $examCatalog->exam_title ?? '') }}"
            class="w-full border-gray-300 rounded px-3 py-2 shadow-sm focus:outline-none focus:ring focus:ring-blue-300">
        @error('exam_title')<div class="text-red-500 text-sm mt-1">{{ $message }}</div>@enderror
    </div>

    <div>
        <label class="block font-medium mb-1">Duration (minutes)</label>
        <input type="number" name="duration_minutes" value="{{ old('duration_minutes', $examCatalog->duration_minutes ?? '') }}"
            class="w-full border-gray-300 rounded px-3 py-2 shadow-sm focus:outline-none focus:ring focus:ring-blue-300">
        @error('duration_minutes')<div class="text-red-500 text-sm mt-1">{{ $message }}</div>@enderror
    </div>

    <div>
        <label class="block font-medium mb-1">Exam Type</label>
        <select name="exam_type" class="w-full border-gray-300 rounded px-3 py-2 shadow-sm focus:outline-none focus:ring focus:ring-blue-300">
            <option value="Practical" {{ old('exam_type', $examCatalog->exam_type ?? '') === 'Practical' ? 'selected' : '' }}>Practical</option>
            <option value="MCQ" {{ old('exam_type', $examCatalog->exam_type ?? '') === 'MCQ' ? 'selected' : '' }}>MCQ</option>
        </select>
        @error('exam_type')<div class="text-red-500 text-sm mt-1">{{ $message }}</div>@enderror
    </div>
</div>

<div class="mt-6">
    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">{{ $button }}</button>
    <a href="{{ route('admin.exam-catalogs.index') }}" class="ml-2 text-gray-600 hover:underline">Cancel</a>
</div>
