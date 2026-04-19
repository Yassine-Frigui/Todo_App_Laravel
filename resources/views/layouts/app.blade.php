<!DOCTYPE html>
<html lang="fr">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>@yield('title', 'Todo App')</title>
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;700&family=Fraunces:opsz,wght@9..144,600;9..144,700&display=swap" rel="stylesheet">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
	<style>
		:root {
			--bg-start: #f7f3ea;
			--bg-end: #ecf2ff;
			--ink: #252525;
			--muted: #646464;
			--brand: #0f766e;
			--brand-strong: #115e59;
			--surface: rgba(255, 255, 255, 0.85);
			--border: rgba(37, 37, 37, 0.12);
			--shadow: 0 14px 40px rgba(0, 0, 0, 0.08);
		}

		body {
			min-height: 100vh;
			font-family: 'DM Sans', sans-serif;
			color: var(--ink);
			background:
				radial-gradient(circle at 0% 0%, rgba(15, 118, 110, 0.16), transparent 40%),
				radial-gradient(circle at 100% 100%, rgba(37, 99, 235, 0.15), transparent 45%),
				linear-gradient(130deg, var(--bg-start), var(--bg-end));
		}

		.page-shell {
			max-width: 980px;
		}

		.surface-card {
			background: var(--surface);
			backdrop-filter: blur(8px);
			border: 1px solid var(--border);
			border-radius: 1.1rem;
			box-shadow: var(--shadow);
		}

		.brand-title {
			font-family: 'Fraunces', serif;
			font-size: clamp(1.8rem, 3vw, 2.4rem);
			line-height: 1.15;
			margin: 0;
		}

		.text-muted-soft {
			color: var(--muted);
		}

		.btn-brand {
			background: linear-gradient(135deg, var(--brand), var(--brand-strong));
			color: #fff;
			border: none;
		}

		.btn-brand:hover,
		.btn-brand:focus {
			color: #fff;
			opacity: 0.95;
		}

		.animated-in {
			animation: fadeSlide .45s ease both;
		}

		@keyframes fadeSlide {
			from {
				opacity: 0;
				transform: translateY(12px);
			}
			to {
				opacity: 1;
				transform: translateY(0);
			}
		}
	</style>
	@stack('styles')
</head>
<body>
	<main class="container py-4 py-md-5 page-shell">
		<section class="surface-card p-3 p-md-4 mb-4 animated-in">
			<div class="d-flex flex-column gap-2">
				<p class="text-uppercase text-muted-soft fw-semibold mb-0" style="letter-spacing: .12em; font-size: .75rem;">Tableau personnel</p>
				<h1 class="brand-title">Todo App</h1>
				<p class="mb-0 text-muted-soft">Garde une vision claire de tes priorites et avance une tache a la fois.</p>
			</div>
		</section>

		@if(session('success'))
			<div class="alert alert-success border-0 shadow-sm animated-in" role="alert">
				{{ session('success') }}
			</div>
		@endif

		<section class="animated-in">
			@yield('content')
		</section>
	</main>
</body>
</html>