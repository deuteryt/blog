<!-- resources/views/layouts/app.blade.php -->
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Blog')</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            line-height: 1.6;
            color: #333;
            background: #f8f9fa;
        }
        
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }
        
        /* Header */
        header {
            background: #fff;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            position: sticky;
            top: 0;
            z-index: 100;
        }
        
        nav {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1rem 0;
        }
        
        .logo {
            font-size: 1.5rem;
            font-weight: bold;
            color: #2563eb;
            text-decoration: none;
        }
        
        .nav-menu {
            display: flex;
            list-style: none;
            gap: 2rem;
        }
        
        .nav-menu a {
            text-decoration: none;
            color: #333;
            font-weight: 500;
            transition: color 0.3s;
        }
        
        .nav-menu a:hover {
            color: #2563eb;
        }
        
        .menu-toggle {
            display: none;
            background: none;
            border: none;
            font-size: 1.5rem;
            cursor: pointer;
        }
        
        /* Main Content */
        main {
            min-height: calc(100vh - 140px);
            padding: 2rem 0;
        }
        
        .content-grid {
            display: grid;
            grid-template-columns: 280px 1fr;
            gap: 2rem;
        }
        
        /* Sidebar */
        .sidebar {
            background: #fff;
            padding: 1.5rem;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            height: fit-content;
        }
        
        .sidebar h3 {
            margin-bottom: 1rem;
            color: #2563eb;
            font-size: 1.1rem;
        }
        
        .category-list {
            list-style: none;
        }
        
        .category-list li {
            margin-bottom: 0.5rem;
        }
        
        .category-list a {
            text-decoration: none;
            color: #333;
            display: block;
            padding: 0.5rem 0;
            border-bottom: 1px solid #eee;
            transition: color 0.3s;
        }
        
        .category-list a:hover {
            color: #2563eb;
        }
        
        .subcategory {
            margin-left: 1rem;
            font-size: 0.9rem;
        }
        
        /* Posts */
        .posts-container {
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            overflow: hidden;
        }
        
        .post-item {
            padding: 1.5rem;
            border-bottom: 1px solid #eee;
        }
        
        .post-item:last-child {
            border-bottom: none;
        }
        
        .post-title {
            font-size: 1.3rem;
            margin-bottom: 0.5rem;
        }
        
        .post-title a {
            text-decoration: none;
            color: #333;
            transition: color 0.3s;
        }
        
        .post-title a:hover {
            color: #2563eb;
        }
        
        .post-meta {
            font-size: 0.9rem;
            color: #666;
            margin-bottom: 1rem;
        }
        
        .post-excerpt {
            color: #555;
            line-height: 1.6;
        }
        
        /* Pagination */
        .pagination {
            display: flex;
            justify-content: center;
            margin-top: 2rem;
            gap: 0.5rem;
        }
        
        .pagination a,
        .pagination span {
            padding: 0.5rem 1rem;
            text-decoration: none;
            color: #333;
            border: 1px solid #ddd;
            border-radius: 4px;
            transition: all 0.3s;
        }
        
        .pagination a:hover {
            background: #2563eb;
            color: white;
            border-color: #2563eb;
        }
        
        .pagination .active {
            background: #2563eb;
            color: white;
            border-color: #2563eb;
        }
        
        /* Footer */
        footer {
            background: #333;
            color: white;
            text-align: center;
            padding: 2rem 0;
            margin-top: 3rem;
        }
        
        /* Responsive */
        @media (max-width: 768px) {
            .nav-menu {
                display: none;
                position: absolute;
                top: 100%;
                left: 0;
                right: 0;
                background: white;
                flex-direction: column;
                box-shadow: 0 2px 4px rgba(0,0,0,0.1);
                padding: 1rem;
            }
            
            .nav-menu.active {
                display: flex;
            }
            
            .menu-toggle {
                display: block;
            }
            
            .content-grid {
                grid-template-columns: 1fr;
            }
            
            .sidebar {
                order: 2;
            }
        }
        
        @media (max-width: 480px) {
            .container {
                padding: 0 15px;
            }
            
            .post-item {
                padding: 1rem;
            }
            
            .post-title {
                font-size: 1.1rem;
            }
        }
    </style>
</head>
<body>
    <header>
        <div class="container">
            <nav>
                <a href="{{ route('blog.index') }}" class="logo">Blog</a>
                <button class="menu-toggle" onclick="toggleMenu()">☰</button>
                <ul class="nav-menu" id="navMenu">
                    <li><a href="{{ route('blog.index') }}">Strona główna</a></li>
                    <li><a href="#">O nas</a></li>
                    <li><a href="#">Kontakt</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <main>
        <div class="container">
            <div class="content-grid">
                <aside class="sidebar">
                    <h3>Kategorie</h3>
                    <ul class="category-list">
                        @foreach($categories as $category)
                            <li>
                                <a href="{{ route('blog.category', $category) }}">
                                    {{ $category->name }}
                                </a>
                                @if($category->children->count() > 0)
                                    <ul class="subcategory">
                                        @foreach($category->children as $subcategory)
                                            <li>
                                                <a href="{{ route('blog.category', $subcategory) }}">
                                                    {{ $subcategory->name }}
                                                </a>
                                            </li>
                                        @endforeach
                                    </ul>
                                @endif
                            </li>
                        @endforeach
                    </ul>
                </aside>

                <div class="main-content">
                    @yield('content')
                </div>
            </div>
        </div>
    </main>

    <footer>
        <div class="container">
            <p>&copy; 2025 Blog. Wszystkie prawa zastrzeżone.</p>
        </div>
    </footer>

    <script>
        function toggleMenu() {
            const menu = document.getElementById('navMenu');
            menu.classList.toggle('active');
        }
    </script>
</body>
</html>