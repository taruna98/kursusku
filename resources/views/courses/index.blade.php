
<x-app-layout>
    <style>
        .courses-page {
            max-width: 1200px;
            margin: 0 auto;
            padding: 40px 24px;
        }

        .courses-layout {
            display: flex;
            gap: 28px;
            align-items: flex-start;
        }

        /* Sidebar */
        .courses-sidebar {
            width: 220px;
            flex-shrink: 0;
            background: #fff;
            border: 1px solid #e5e7eb;
            border-radius: 12px;
            padding: 20px;
            position: sticky;
            top: 80px;
        }

        .filter-group {
            display: flex;
            flex-direction: column;
            gap: 6px;
        }

        .filter-label {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 0.875rem;
            color: #374151;
            cursor: pointer;
        }

        .filter-label input {
            accent-color: #2563eb;
        }

        /* Main content */
        .courses-content {
            flex: 1;
            min-width: 0;
        }

        /* Search bar */
        .courses-toolbar {
            display: flex;
            align-items: center;
            justify-content: flex-end;
            gap: 12px;
            margin-bottom: 16px;
        }

        .courses-search {
            display: flex;
            align-items: center;
            gap: 8px;
            min-width: 0;
        }

        .courses-search input {
            width: 240px;
            max-width: 100%;
            min-width: 0;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            padding: 9px 14px;
            font-size: 0.875rem;
            font-family: 'Inter', sans-serif;
            outline: none;
        }

        .courses-search input:focus {
            border-color: #2563eb;
        }

        .courses-search button {
            background: #2563eb;
            color: #fff;
            border: none;
            border-radius: 8px;
            padding: 10px 16px;
            font-size: 0.875rem;
            font-weight: 600;
            cursor: pointer;
            white-space: nowrap;
        }

        /* Course grid */
        .courses-grid {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 20px;
        }

        /* Tablet */
        @media (max-width: 1024px) {
            .courses-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }
        }

        /* Mobile */
        @media (max-width: 767px) {
            .courses-page {
                padding: 24px 16px;
            }

            .courses-layout {
                flex-direction: column;
                gap: 20px;
            }

            .courses-sidebar {
                width: 100%;
                position: static;
                padding: 16px;
            }

            .courses-content {
                width: 100%;
            }

            .courses-toolbar {
                flex-direction: column;
                align-items: stretch;
                gap: 12px;
            }

            .courses-search {
                width: 100%;
            }

            .courses-search input {
                flex: 1;
                width: 100%;
            }

            .courses-grid {
                grid-template-columns: repeat(1, minmax(0, 1fr));
                gap: 16px;
            }
        }

        /* Small mobile */
        @media (max-width: 380px) {
            .courses-page {
                padding: 20px 12px;
            }

            .courses-search {
                gap: 6px;
            }

            .courses-search button {
                padding: 10px 12px;
            }
        }
    </style>

    <div class="courses-page">

        {{-- Header --}}
        <h1 style="font-size:1.375rem;font-weight:700;color:#111827;margin-bottom:10px;">
            Jelajahi Kursus
        </h1>

        <p style="font-size:0.875rem;color:#6b7280;margin-bottom:32px;">
            Temukan kursus yang sesuai dengan minatmu
        </p>

        {{-- Layout --}}
        <div class="courses-layout">

            {{-- Sidebar Filter --}}
            <aside class="courses-sidebar">

                <form method="GET" action="{{ route('courses.index') }}" id="filter-form">

                    @if(request('search'))
                        <input type="hidden" name="search" value="{{ request('search') }}">
                    @endif

                    {{-- Kategori --}}
                    <div style="margin-bottom:20px;">

                        <p style="font-size:0.75rem;font-weight:700;color:#9ca3af;text-transform:uppercase;letter-spacing:.05em;margin-bottom:10px;">
                            Kategori
                        </p>

                        <div class="filter-group">

                            <label class="filter-label">
                                <input
                                    type="radio"
                                    name="category"
                                    value=""
                                    {{ !request('category') ? 'checked' : '' }}
                                    onchange="document.getElementById('filter-form').submit()"
                                >
                                Semua Kategori
                            </label>

                            @foreach($categories as $cat)
                                <label class="filter-label">
                                    <input
                                        type="radio"
                                        name="category"
                                        value="{{ $cat->id }}"
                                        {{ request('category') == $cat->id ? 'checked' : '' }}
                                        onchange="document.getElementById('filter-form').submit()"
                                    >
                                    {{ $cat->name }}
                                </label>
                            @endforeach

                        </div>
                    </div>

                    {{-- Harga --}}
                    <div>

                        <p style="font-size:0.75rem;font-weight:700;color:#9ca3af;text-transform:uppercase;letter-spacing:.05em;margin-bottom:10px;">
                            Harga
                        </p>

                        <div class="filter-group">

                            <label class="filter-label">
                                <input
                                    type="radio"
                                    name="price"
                                    value=""
                                    {{ !request('price') ? 'checked' : '' }}
                                    onchange="document.getElementById('filter-form').submit()"
                                >
                                Semua Harga
                            </label>

                            <label class="filter-label">
                                <input
                                    type="radio"
                                    name="price"
                                    value="free"
                                    {{ request('price') === 'free' ? 'checked' : '' }}
                                    onchange="document.getElementById('filter-form').submit()"
                                >
                                Gratis
                            </label>

                            <label class="filter-label">
                                <input
                                    type="radio"
                                    name="price"
                                    value="paid"
                                    {{ request('price') === 'paid' ? 'checked' : '' }}
                                    onchange="document.getElementById('filter-form').submit()"
                                >
                                Berbayar
                            </label>

                        </div>
                    </div>

                    {{-- Reset --}}
                    @if(request('category') || request('price'))
                        <a
                            href="{{ route('courses.index', request('search') ? ['search' => request('search')] : []) }}"
                            style="display:block;margin-top:20px;font-size:0.8125rem;color:#6b7280;text-decoration:underline;"
                        >
                            Reset filter
                        </a>
                    @endif

                </form>
            </aside>

            {{-- Content --}}
            <div class="courses-content">

                {{-- Search + Sort --}}
                <div class="courses-toolbar">

                    <span style="font-size:0.875rem;color:#6b7280;white-space:nowrap;">
                        {{ $courses->total() }} kursus ditemukan
                    </span>

                    <form
                        method="GET"
                        action="{{ route('courses.index') }}"
                        class="courses-search"
                    >

                        @if(request('category'))
                            <input type="hidden" name="category" value="{{ request('category') }}">
                        @endif

                        @if(request('price'))
                            <input type="hidden" name="price" value="{{ request('price') }}">
                        @endif

                        <input
                            type="text"
                            name="search"
                            value="{{ request('search') }}"
                            placeholder="Cari kursus..."
                        >

                        <button type="submit">
                            Cari
                        </button>

                    </form>
                </div>

                {{-- Course List --}}
                @if($courses->isEmpty())

                    <div style="text-align:center;padding:60px 0;color:#9ca3af;font-size:0.9375rem;">
                        Tidak ada kursus yang ditemukan.
                    </div>

                @else

                    <div class="courses-grid">

                        @foreach($courses as $course)
                            <x-course-card :course="$course"/>
                        @endforeach

                    </div>

                    {{-- Pagination --}}
                    <div style="margin-top:28px;">
                        {{ $courses->withQueryString()->links() }}
                    </div>

                @endif

            </div>
        </div>
    </div>
</x-app-layout>
