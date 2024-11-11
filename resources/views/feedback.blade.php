<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Feedback Produk</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .feedback-container {
            max-width: 600px;
            margin: 50px auto;
            padding: 30px;
            background: white;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0,0,0,0.1);
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="/">Beranda</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="/logout">Logout</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">{{ Auth::user()->name }}</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <div class="container">
        <div class="feedback-container">
            <h2 class="text-center mb-4">Feedback Produk</h2>
            
            <form action="{{ route('feedback.store') }}" method="POST" id="feedbackForm">
                @csrf
                <div class="mb-3">
                    <label for="nama" class="form-label">Nama</label>
                    <input type="text" class="form-control" id="nama" name="nama" required>
                </div>
                
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" name="email" required>
                </div>
                
                <div class="mb-3">
                    <label for="komentar" class="form-label">Komentar</label>
                    <textarea class="form-control" id="komentar" name="komentar" rows="4" required></textarea>
                </div>
                
                <div class="d-grid">
                    <button type="submit" class="btn btn-primary">Kirim Feedback</button>
                </div>
            </form>

            <div id="feedbackList" class="mt-5">
                <h3>Feedback Terbaru</h3>
                <div class="list-group" id="feedbackItems">
                    @foreach($feedbacks as $feedback)
                        <div class="list-group-item">
                            <div class="d-flex w-100 justify-content-between">
                                Nama : <h5 class="mb-1">{{ $feedback->nama }}</h5>
                                Email : <small>{{ $feedback->email }}</small>
                            </div>
                            Komentar : <p class="mb-1">{{ $feedback->komentar }}</p>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.getElementById('feedbackForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Mengambil nilai input
            const nama = document.getElementById('nama').value;
            const email = document.getElementById('email').value;
            const komentar = document.getElementById('komentar').value;
            
            // Membuat elemen feedback baru
            const feedbackItem = document.createElement('div');
            feedbackItem.className = 'list-group-item';
            feedbackItem.innerHTML = `
                <div class="d-flex w-100 justify-content-between">
                     Nama : <h5 class="mb-1">${nama}</h5>
                    Email :  <small>${email}</small>
                </div>
                Komentar : <p class="mb-1">${komentar}</p>
            `;
            
            // Menambahkan feedback ke daftar
            const feedbackItems = document.getElementById('feedbackItems');
            feedbackItems.insertBefore(feedbackItem, feedbackItems.firstChild);
            
            // Reset form
            this.reset();
        });
    </script>
</body>
</html>
