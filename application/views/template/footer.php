</div> <!-- Tutup Main Content Area -->
</div> <!-- Tutup Flex Wrapper Utama -->

<!-- Script Toggle Dark/Light Mode -->
<script>
    function toggleDarkMode() {
        const html = document.documentElement;
        if (html.classList.contains('dark')) {
            html.classList.remove('dark');
            localStorage.setItem('darkMode', 'false');
        } else {
            html.classList.add('dark');
            localStorage.setItem('darkMode', 'true');
        }
    }
</script>
</body>

</html>