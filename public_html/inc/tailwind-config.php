<?php
/**
 * Centralized Tailwind Configuration
 * Include this file in all pages that use Tailwind CSS
 * Single source of truth for colors, fonts, and theme settings
 * Pinned to v3.4.17 for stability and caching
 */
?>
<!-- Tailwind CSS (pinned version for caching + performance) -->
<script src="https://cdn.tailwindcss.com/3.4.17"></script>
<script>
    tailwind.config = {
        darkMode: 'class',
        theme: {
            extend: {
                colors: {
                    primary: {
                        50: '#f5f3ff', 100: '#ede9fe', 200: '#ddd6fe', 300: '#c4b5fd',
                        400: '#a78bfa', 500: '#7c3aed', 600: '#6d28d9', 700: '#5b21b6',
                        800: '#4c1d95', 900: '#3b0764',
                    },
                    secondary: {
                        50: '#eff6ff', 100: '#dbeafe', 200: '#bfdbfe', 300: '#93c5fd',
                        400: '#60a5fa', 500: '#3b82f6', 600: '#1e40af', 700: '#1e3a8a',
                        800: '#1e3a8a', 900: '#172554',
                    }
                },
                fontFamily: {
                    'sans': ['Inter', 'system-ui', 'sans-serif'],
                    'display': ['Poppins', 'system-ui', 'sans-serif'],
                }
            }
        }
    }
</script>
