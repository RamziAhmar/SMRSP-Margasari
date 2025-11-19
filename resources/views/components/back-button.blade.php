@props(['href' => null])

<a href="{{ $href ?? url()->previous() }}"
   class="inline-flex items-center px-3 py-2 bg-gray-200 border border-gray-300
          rounded-md text-sm text-gray-700 hover:bg-gray-300 focus:outline-none
          focus:ring-2 focus:ring-offset-2 focus:ring-gray-400">
    {{-- icon panah sederhana --}}
    <span class="mr-1">&larr;</span>
    <span>Kembali</span>    
</a>
