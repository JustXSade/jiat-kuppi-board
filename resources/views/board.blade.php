<!DOCTYPE html>
<html lang="en" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Merlin Kuppi & Campus Board</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* Lightweight static icon/dot grid background texture */
        .merlin-bg {
            background-color: #0B0F19;
            background-image: radial-gradient(rgba(139, 92, 246, 0.14) 1px, transparent 1px);
            background-size: 24px 24px;
        }
    </style>
</head>
<body class="merlin-bg text-slate-200 antialiased min-h-screen selection:bg-violet-500 selection:text-white">

    <!-- Top Navbar -->
    <nav class="bg-[#0F1626]/90 backdrop-blur-md sticky top-0 z-20">
        <div class="max-w-6xl mx-auto px-4 py-4 flex flex-wrap items-center justify-between gap-4">
            <div class="flex items-center gap-3.5">
                <div class="w-11 h-11 rounded-2xl bg-gradient-to-br from-violet-600 to-indigo-700 text-white flex items-center justify-center font-extrabold text-xl shadow-lg shadow-violet-950/50">
                    M
                </div>
                <div>
                    <div class="flex items-center gap-2">
                        <h1 class="text-lg font-bold text-white tracking-tight">Merlin Kuppi Board</h1>
                        <span class="px-2 py-0.5 rounded-full text-[11px] font-semibold bg-violet-500/15 text-violet-300">
                            by Team Merlin
                        </span>
                    </div>
                    <p class="text-xs text-slate-400">JIAT Campus Help • Peer Study • Powered by Gemini 2.5 Flash</p>
                </div>
            </div>

            <!-- Live UX Stats & AI Status -->
            <div class="flex flex-wrap items-center gap-2.5 text-xs font-semibold">
                <span class="px-3 py-1.5 rounded-full bg-amber-500/10 text-amber-300">
                    ● {{ $posts->where('status', 'Open')->count() }} Open
                </span>
                <span class="px-3 py-1.5 rounded-full bg-emerald-500/10 text-emerald-300">
                    ✓ {{ $posts->where('status', 'Resolved')->count() }} Resolved
                </span>
                <span class="px-3 py-1.5 rounded-full bg-blue-500/10 text-blue-300">
                    ✨ Gemini 2.5 Ready
                </span>
            </div>
        </div>
    </nav>

    <!-- Main Container -->
    <main class="max-w-6xl mx-auto px-4 py-8 grid grid-cols-1 lg:grid-cols-3 gap-7">

        <!-- Left Column: Create Post Card -->
        <div class="bg-[#131B2E] p-6 rounded-3xl shadow-xl shadow-black/20 h-fit">
            <h2 class="text-lg font-bold text-white mb-1">Summon Kuppi Help</h2>
            <p class="text-xs text-slate-400 mb-5 leading-relaxed">
                Post a question, share notes, or report a lost item. Merlin AI will conjure an instant study guide.
            </p>

            <!-- Red Alert for Validation Errors -->
            @if ($errors->any())
                <div class="mb-4 p-3.5 rounded-2xl bg-red-500/10 text-red-300 text-xs space-y-1">
                    <p class="font-bold text-red-400">Please fix the following:</p>
                    <ul class="list-disc pl-4 space-y-0.5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('board.store') }}" method="POST" id="postForm" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-xs font-semibold text-slate-300 mb-1.5">Your Name / Batch</label>
                    <input type="text" name="author_name" required placeholder="e.g., Thihira (2nd Year SE)"
                        class="w-full rounded-2xl bg-[#0B0F19] text-slate-100 placeholder-slate-500 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-violet-500 transition">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-300 mb-1.5">Category</label>
                    <select name="category"
                        class="w-full rounded-2xl bg-[#0B0F19] text-slate-100 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-violet-500 transition">
                        <option value="Kuppi">🎓 Kuppi Request / Session</option>
                        <option value="Notes">📘 Notes & Past Papers</option>
                        <option value="Coding Help">💻 Coding / Bug Help</option>
                        <option value="Lost & Found">🔍 Lost & Found</option>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-300 mb-1.5">Title</label>
                    <input type="text" name="title" required placeholder="e.g., Need help with Java Polymorphism"
                        class="w-full rounded-2xl bg-[#0B0F19] text-slate-100 placeholder-slate-500 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-violet-500 transition">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-300 mb-1.5">Details / Notes / Code</label>
                    <textarea name="content" rows="4" required placeholder="Explain your question, paste code, or share resource details..."
                        class="w-full rounded-2xl bg-[#0B0F19] text-slate-100 placeholder-slate-500 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-violet-500 transition"></textarea>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-300 mb-1.5">Tags (comma separated)</label>
                    <input type="text" name="tags" placeholder="e.g., Java, OOP, Exam, Gampaha"
                        class="w-full rounded-2xl bg-[#0B0F19] text-slate-100 placeholder-slate-500 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-violet-500 transition">
                </div>

                <button type="submit" id="submitBtn"
                    class="w-full py-3.5 px-4 bg-violet-600 hover:bg-violet-500 text-white font-semibold text-sm rounded-2xl shadow-lg shadow-violet-950/60 transition cursor-pointer flex items-center justify-center gap-2">
                    <span id="btnText">Post & Conjure AI Kuppi ✨</span>
                </button>
            </form>
        </div>

        <!-- Right Column: Search, Filter & Posts Feed -->
        <div class="lg:col-span-2 space-y-6">

            <!-- Search & Category Filter Card -->
            <div class="bg-[#131B2E] p-4 rounded-3xl shadow-xl shadow-black/20 space-y-3.5">
                <form action="{{ route('board.index') }}" method="GET" class="flex gap-2.5">
                    <input type="hidden" name="category" value="{{ $currentCategory }}">
                    <input type="text" name="search" value="{{ $searchQuery }}" placeholder="Search Kuppi topics, tags, or issues..."
                        class="w-full rounded-2xl bg-[#0B0F19] text-slate-100 placeholder-slate-500 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 transition">
                    <button type="submit" class="px-6 py-3 bg-blue-600 hover:bg-blue-500 text-white text-sm font-semibold rounded-2xl transition cursor-pointer">
                        Search
                    </button>
                </form>

                <div class="flex flex-wrap gap-2">
                    @foreach (['All', 'Kuppi', 'Notes', 'Coding Help', 'Lost & Found'] as $cat)
                        <a href="{{ route('board.index', ['category' => $cat, 'search' => $searchQuery]) }}"
                            class="px-4 py-1.5 rounded-full text-xs font-semibold transition {{ $currentCategory === $cat ? 'bg-violet-600 text-white shadow-md shadow-violet-950/50' : 'bg-[#0B0F19] text-slate-400 hover:text-slate-200' }}">
                            {{ $cat }}
                        </a>
                    @endforeach
                </div>
            </div>

            <!-- Posts Feed -->
            <div class="space-y-5">
                @forelse ($posts as $post)
                    @php
                        $catColor = match($post->category) {
                            'Kuppi' => 'bg-violet-500/15 text-violet-300',
                            'Notes' => 'bg-blue-500/15 text-blue-300',
                            'Coding Help' => 'bg-amber-500/15 text-amber-300',
                            'Lost & Found' => 'bg-red-500/15 text-red-300',
                            default => 'bg-slate-700 text-slate-300',
                        };
                    @endphp

                    <div class="bg-[#131B2E] p-6 rounded-3xl shadow-xl shadow-black/20 space-y-4">
                        <div class="flex items-start justify-between gap-4">
                            <div>
                                <div class="flex items-center gap-2.5 mb-2">
                                    <span class="px-3 py-0.5 text-xs font-bold rounded-full {{ $catColor }}">
                                        {{ $post->category }}
                                    </span>
                                    <span class="text-xs text-slate-400">{{ $post->created_at->diffForHumans() }}</span>
                                </div>
                                <h3 class="text-lg font-bold text-white leading-snug">{{ $post->title }}</h3>
                                <p class="text-xs text-slate-400 mt-0.5">Posted by <span class="font-semibold text-slate-200">{{ $post->author_name }}</span></p>
                            </div>

                            <!-- Yellow (Open) / Green (Resolved) Status Toggle Button -->
                            <form action="{{ route('board.toggle', $post) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <button type="submit"
                                    class="px-3.5 py-1.5 rounded-full text-xs font-bold transition cursor-pointer {{ $post->status === 'Open' ? 'bg-amber-500/15 text-amber-300 hover:bg-amber-500/25' : 'bg-emerald-500/15 text-emerald-300 hover:bg-emerald-500/25' }}">
                                    {{ $post->status === 'Open' ? '● Open (Mark Resolved)' : '✓ Resolved' }}
                                </button>
                            </form>
                        </div>

                        <p class="text-sm text-slate-300 whitespace-pre-line leading-relaxed">{{ $post->content }}</p>

                        <!-- Gemini AI Instant Kuppi Answer Box -->
                        @if ($post->ai_summary)
                            <div class="p-4 rounded-2xl bg-[#0B0F19]/90 space-y-2">
                                <div class="flex items-center justify-between gap-2">
                                    <span class="text-xs font-bold text-amber-300 flex items-center gap-1.5">
                                        ✨ Merlin AI Instant Kuppi Guide
                                    </span>
                                    <button type="button" onclick="copyText(this, `{{ addslashes($post->ai_summary) }}`)"
                                        class="text-[11px] font-semibold px-2.5 py-1 rounded-lg bg-slate-800 hover:bg-slate-700 text-slate-300 transition cursor-pointer">
                                        Copy Guide
                                    </button>
                                </div>
                                <div class="text-sm text-slate-200 whitespace-pre-line leading-relaxed">{{ $post->ai_summary }}</div>
                            </div>
                        @endif

                        @if ($post->tags)
                            <div class="flex flex-wrap gap-2 pt-1">
                                @foreach (explode(',', $post->tags) as $tag)
                                    <span class="text-xs bg-[#0B0F19] text-slate-400 px-3 py-1 rounded-xl font-medium">
                                        #{{ trim($tag) }}
                                    </span>
                                @endforeach
                            </div>
                        @endif
                    </div>
                @empty
                    <div class="bg-[#131B2E] p-12 rounded-3xl shadow-xl shadow-black/20 text-center space-y-2">
                        <p class="text-base font-bold text-white">The Merlin Board is quiet right now</p>
                        <p class="text-xs text-slate-400">Create the first Kuppi request or share a note to see Gemini AI in action!</p>
                    </div>
                @endforelse
            </div>
        </div>

    </main>

    <script>
        // Loading state UX when calling Gemini API
        document.getElementById('postForm').addEventListener('submit', function() {
            const btn = document.getElementById('submitBtn');
            const text = document.getElementById('btnText');
            btn.disabled = true;
            btn.classList.add('opacity-75', 'cursor-not-allowed');
            text.innerText = '✨ Merlin AI is conjuring your Kuppi guide...';
        });

        // Copy AI answer UX
        function copyText(btn, text) {
            navigator.clipboard.writeText(text);
            const original = btn.innerText;
            btn.innerText = '✓ Copied!';
            btn.classList.add('text-emerald-300');
            setTimeout(() => {
                btn.innerText = original;
                btn.classList.remove('text-emerald-300');
            }, 2000);
        }
    </script>
</body>
</html>