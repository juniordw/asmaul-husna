<!-- resources/views/game/index.blade.php -->
@extends('layouts.app')

@push('styles')
<style>
    .game-item {
        cursor: pointer;
        transition: all 0.3s ease;
        position: relative;
    }

    .game-item.selected {
        background-color: #93c5fd !important;
    }

    .game-item.matched {
        background-color: #86efac !important;
        cursor: default;
    }

    .line {
        position: absolute;
        height: 3px;
        background-color: #22c55e;
        transform-origin: left center;
        pointer-events: none;
        z-index: 1;
    }

    .shake {
        animation: shake 0.5s;
    }

    @keyframes shake {
        0%, 100% { transform: translateX(0); }
        25% { transform: translateX(-10px); }
        75% { transform: translateX(10px); }
    }

    #game-container {
        position: relative;
        min-height: 400px;
    }

    .columns-container {
        position: relative;
        z-index: 2;
    }
</style>
@endpush

@section('content')
<div class="max-w-4xl mx-auto bg-white rounded-lg shadow-lg p-6">
    <!-- Header -->
    <div class="text-center mb-8">
        <h1 class="text-3xl font-bold text-gray-800">Asmaul Husna</h1>
        <p class="text-gray-600 mt-2">Hubungkan Asmaul Husna dengan artinya</p>
        <div class="mt-4">
            <span class="text-green-600 text-lg font-semibold" id="score">Skor: 0</span>
        </div>
    </div>

    <!-- Game Container -->
    <div class="relative" id="game-container">
        <!-- Lines Container -->
        <div id="lines-container" class="absolute inset-0"></div>
        
        <!-- Columns Container -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 columns-container">
            <!-- Names Column -->
            <div class="space-y-4">
                @foreach($asmaul_husna as $index => $item)
                <div class="game-item name-item bg-blue-100 p-4 rounded-lg text-center hover:shadow-md"
                     data-index="{{ $index }}"
                     data-name="{{ $item['name'] }}">
                    {{ $item['name'] }}
                </div>
                @endforeach
            </div>

            <!-- Meanings Column -->
            <div class="space-y-4">
                @foreach($asmaul_husna as $index => $item)
                <div class="game-item meaning-item bg-green-100 p-4 rounded-lg text-center hover:shadow-md"
                     data-index="{{ $index }}"
                     data-meaning="{{ $item['meaning'] }}"
                     data-pair="{{ $item['name'] }}">
                    {{ $item['meaning'] }}
                </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Controls -->
    <div class="mt-8 text-center">
        <button onclick="resetGame()" 
                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded-lg transition duration-300">
            Mulai Ulang
        </button>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    let score = 0;
    let selectedItem = null;
    const container = $('#game-container');
    const linesContainer = $('#lines-container');
    
    // Acak posisi meanings di awal
    const meaningItems = $('.meaning-item').toArray();
    meaningItems.sort(() => Math.random() - 0.5);
    meaningItems.forEach(item => {
        $(item).parent().append(item);
    });

    // Handle click pada item
    $('.game-item').click(function() {
        if ($(this).hasClass('matched')) {
            return;
        }

        if (!selectedItem) {
            // First click - harus pada name-item
            if ($(this).hasClass('name-item')) {
                selectedItem = $(this);
                $(this).addClass('selected');
            }
        } else {
            // Second click - harus pada meaning-item
            if ($(this).hasClass('meaning-item')) {
                const isMatch = selectedItem.data('name') === $(this).data('pair');
                
                if (isMatch) {
                    // Benar - tambah score dan tandai sebagai matched
                    score += 20;
                    $('#score').text(`Skor: ${score}`);
                    
                    selectedItem.removeClass('selected').addClass('matched');
                    $(this).addClass('matched');
                    
                    // Buat garis penghubung
                    connectElements(selectedItem[0], this);

                    // Cek apakah permainan selesai
                    if (score === 100) {
                        setTimeout(() => {
                            alert('Selamat! Anda telah menyelesaikan permainan!');
                        }, 300);
                    }
                } else {
                    // Salah - tambah efek shake
                    selectedItem.addClass('shake');
                    $(this).addClass('shake');
                    setTimeout(() => {
                        $('.shake').removeClass('shake');
                    }, 500);
                }
                
                // Reset selection
                selectedItem.removeClass('selected');
                selectedItem = null;
            }
        }
    });

    function connectElements(elem1, elem2) {
        const $elem1 = $(elem1);
        const $elem2 = $(elem2);
        
        const offset1 = $elem1.offset();
        const offset2 = $elem2.offset();
        const containerOffset = container.offset();
        
        // Hitung posisi relatif terhadap container
        const x1 = offset1.left + $elem1.outerWidth() - containerOffset.left;
        const y1 = offset1.top + $elem1.outerHeight()/2 - containerOffset.top;
        const x2 = offset2.left - containerOffset.left;
        const y2 = offset2.top + $elem2.outerHeight()/2 - containerOffset.top;
        
        // Hitung panjang dan sudut garis
        const length = Math.sqrt(Math.pow(x2 - x1, 2) + Math.pow(y2 - y1, 2));
        const angle = Math.atan2(y2 - y1, x2 - x1) * 180 / Math.PI;
        
        // Buat garis baru
        const line = $('<div>').addClass('line').css({
            left: x1 + 'px',
            top: y1 + 'px',
            width: length + 'px',
            transform: `rotate(${angle}deg)`
        });
        
        // Tambahkan data untuk keperluan resize
        line.data({
            'elem1': elem1,
            'elem2': elem2
        });
        
        linesContainer.append(line);
    }

    // Fungsi untuk update posisi semua garis
    function updateLines() {
        $('.line').each(function() {
            const $line = $(this);
            const elem1 = $line.data('elem1');
            const elem2 = $line.data('elem2');
            if (elem1 && elem2) {
                $line.remove();
                connectElements(elem1, elem2);
            }
        });
    }

    // Fungsi reset game
    window.resetGame = function() {
        score = 0;
        $('#score').text('Skor: 0');
        
        // Hapus semua garis
        $('.line').remove();
        
        // Reset semua item
        $('.game-item').removeClass('matched selected shake');
        
        // Acak ulang meanings
        const meaningItems = $('.meaning-item').toArray();
        meaningItems.sort(() => Math.random() - 0.5);
        meaningItems.forEach(item => {
            $(item).parent().append(item);
        });
        
        selectedItem = null;
    };

    // Update garis saat window di-resize
    $(window).on('resize', _.debounce(function() {
        updateLines();
    }, 100));
});
</script>
@endpush