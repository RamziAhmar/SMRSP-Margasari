<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Tambah Pengukuran: {{ $balita->nama }}
        </h2>
    </x-slot>

    <div class="py-6 max-w-3xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white shadow-sm sm:rounded-lg p-6">
            <form method="POST" action="{{ route('pengukuran.store', $balita->id_balita) }}">
                @php
                    $ldate = Carbon\Carbon::now();

                @endphp
                @csrf

                {{-- Tanggal Ukur --}}
                <div>
                    <x-input-label for="tanggal_ukur" value="Tanggal Ukur" />
                    <x-text-input id="tanggal_ukur" name="tanggal_ukur" type="text" class="mt-1 block w-full"
                        value="{{ $ldate->toDateString() }}" required disabled/>
                    <x-input-error :messages="$errors->get('tanggal_ukur')" class="mt-2" />
                </div>

                {{-- Berat Badan --}}
                <div class="mt-4">
                    <x-input-label for="bb_kg" value="Berat Badan (kg)" />
                    <x-text-input id="bb_kg" name="bb_kg" type="number" step="0.01" class="mt-1 block w-full"
                        :value="old('bb_kg')" required />
                    <x-input-error :messages="$errors->get('bb_kg')" class="mt-2" />
                </div>

                {{-- Tinggi Badan --}}
                <div class="mt-4">
                    <x-input-label for="tb_cm" value="Tinggi Badan (cm)" />
                    <x-text-input id="tb_cm" name="tb_cm" type="number" step="0.1" class="mt-1 block w-full"
                        :value="old('tb_cm')" required />
                    <x-input-error :messages="$errors->get('tb_cm')" class="mt-2" />
                </div>

                {{-- LILA --}}
                <div class="mt-4">
                    <x-input-label for="lila_cm" value="Lingkar Lengan Atas / LILA (cm) (opsional)" />
                    <x-text-input id="lila_cm" name="lila_cm" type="number" step="0.1" class="mt-1 block w-full"
                        :value="old('lila_cm')" />
                    <x-input-error :messages="$errors->get('lila_cm')" class="mt-2" />
                </div>

                <div class="mt-6 flex justify-end gap-2">
                    <x-back-button :href="route('balita.index')" />
                    <x-primary-button>
                        Simpan Pengukuran
                    </x-primary-button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
