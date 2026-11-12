<?php
/**
 * Admin Panel Footer
 */
?>
            </div><!-- /admin-content -->
        </main>
    </div><!-- /admin-wrapper -->

    <script>
        // Sidebar Toggle for Mobile
        const sidebarToggle = document.getElementById('sidebarToggle');
        const adminSidebar = document.getElementById('adminSidebar');
        if (sidebarToggle && adminSidebar) {
            sidebarToggle.addEventListener('click', () => {
                adminSidebar.classList.toggle('show');
            });
        }

        // Generic delete confirm helper
        function confirmDeletion(event, itemName) {
            if (!confirm(`Are you certain you wish to delete this ${itemName}? This action cannot be reversed.`)) {
                event.preventDefault();
                return false;
            }
            return true;
        }
    </script>
</body>
</html>
