#!/bin/bash

# ============================================================
#  Laravel Skeleton — Offline Assets Downloader
#  Jalankan dari ROOT folder project Laravel
#  Usage: bash download-assets.sh
# ============================================================

set -e

GREEN='\033[0;32m'
YELLOW='\033[1;33m'
CYAN='\033[0;36m'
NC='\033[0m'

log()  { echo -e "${GREEN}[✔]${NC} $1"; }
info() { echo -e "${CYAN}[→]${NC} $1"; }
warn() { echo -e "${YELLOW}[!]${NC} $1"; }

echo ""
echo "========================================"
echo "   Laravel Skeleton — Offline Setup"
echo "========================================"
echo ""

# ── Buat folder ──────────────────────────────────────────────
info "Membuat folder assets..."
mkdir -p public/assets/css
mkdir -p public/assets/js
mkdir -p public/assets/fonts
mkdir -p public/assets/img
log "Folder siap"

# ── Download CSS ─────────────────────────────────────────────
info "Download Bootstrap CSS..."
curl -sL "https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" \
     -o public/assets/css/bootstrap.min.css
log "bootstrap.min.css"

info "Download Bootstrap Icons CSS..."
curl -sL "https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" \
     -o public/assets/css/bootstrap-icons.min.css
log "bootstrap-icons.min.css"

# ── Download JS ──────────────────────────────────────────────
info "Download jQuery..."
curl -sL "https://code.jquery.com/jquery-3.7.1.min.js" \
     -o public/assets/js/jquery.min.js
log "jquery.min.js"

info "Download Bootstrap Bundle JS..."
curl -sL "https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" \
     -o public/assets/js/bootstrap.bundle.min.js
log "bootstrap.bundle.min.js"

# ── Download Bootstrap Icons Fonts ───────────────────────────
info "Download Bootstrap Icons fonts..."
curl -sL "https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/fonts/bootstrap-icons.woff2" \
     -o public/assets/fonts/bootstrap-icons.woff2
curl -sL "https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/fonts/bootstrap-icons.woff" \
     -o public/assets/fonts/bootstrap-icons.woff
log "bootstrap-icons.woff2 & .woff"

# ── Fix path font di bootstrap-icons.min.css ─────────────────
info "Fix path font di bootstrap-icons.min.css..."
if [[ "$OSTYPE" == "darwin"* ]]; then
    # macOS
    sed -i '' 's|url("fonts/bootstrap-icons.woff2|url("../fonts/bootstrap-icons.woff2|g' \
        public/assets/css/bootstrap-icons.min.css
    sed -i '' 's|url("fonts/bootstrap-icons.woff|url("../fonts/bootstrap-icons.woff|g' \
        public/assets/css/bootstrap-icons.min.css
else
    # Linux / Git Bash Windows
    sed -i 's|url("fonts/bootstrap-icons.woff2|url("../fonts/bootstrap-icons.woff2|g' \
        public/assets/css/bootstrap-icons.min.css
    sed -i 's|url("fonts/bootstrap-icons.woff|url("../fonts/bootstrap-icons.woff|g' \
        public/assets/css/bootstrap-icons.min.css
fi
log "Path font sudah diperbaiki"

# ── Buat default avatar SVG ───────────────────────────────────
info "Membuat default avatar..."
cat > public/assets/img/default-avatar.png << 'SVGEOF'
SVGEOF

# Buat SVG sebagai fallback avatar (simpan sebagai .svg lalu convert)
cat > public/assets/img/default-avatar.svg << 'SVGEOF'
<svg xmlns="http://www.w3.org/2000/svg" width="80" height="80" viewBox="0 0 80 80">
  <rect width="80" height="80" rx="40" fill="#4f46e5"/>
  <circle cx="40" cy="30" r="14" fill="rgba(255,255,255,0.9)"/>
  <ellipse cx="40" cy="70" rx="22" ry="16" fill="rgba(255,255,255,0.9)"/>
</svg>
SVGEOF
log "default-avatar.svg"

# ── Update layouts/app.blade.php ─────────────────────────────
info "Update resources/views/layouts/app.blade.php..."

LAYOUT_FILE="resources/views/layouts/app.blade.php"

if [ -f "$LAYOUT_FILE" ]; then
    # Backup dulu
    cp "$LAYOUT_FILE" "${LAYOUT_FILE}.bak"

    # Replace CDN links
    sed -i 's|https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css|{{ asset('\''assets/css/bootstrap.min.css'\'') }}|g' "$LAYOUT_FILE"
    sed -i 's|https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css|{{ asset('\''assets/css/bootstrap-icons.min.css'\'') }}|g' "$LAYOUT_FILE"
    sed -i 's|https://code.jquery.com/jquery-3.7.1.min.js|{{ asset('\''assets/js/jquery.min.js'\'') }}|g' "$LAYOUT_FILE"
    sed -i 's|https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js|{{ asset('\''assets/js/bootstrap.bundle.min.js'\'') }}|g' "$LAYOUT_FILE"

    log "layouts/app.blade.php updated (backup: app.blade.php.bak)"
else
    warn "File $LAYOUT_FILE tidak ditemukan, skip."
fi

# ── Update auth/login.blade.php ──────────────────────────────
info "Update resources/views/auth/login.blade.php..."

LOGIN_FILE="resources/views/auth/login.blade.php"

if [ -f "$LOGIN_FILE" ]; then
    cp "$LOGIN_FILE" "${LOGIN_FILE}.bak"

    sed -i 's|https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css|{{ asset('\''assets/css/bootstrap.min.css'\'') }}|g' "$LOGIN_FILE"
    sed -i 's|https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css|{{ asset('\''assets/css/bootstrap-icons.min.css'\'') }}|g' "$LOGIN_FILE"
    sed -i 's|https://code.jquery.com/jquery-3.7.1.min.js|{{ asset('\''assets/js/jquery.min.js'\'') }}|g' "$LOGIN_FILE"
    sed -i 's|https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js|{{ asset('\''assets/js/bootstrap.bundle.min.js'\'') }}|g' "$LOGIN_FILE"

    log "auth/login.blade.php updated (backup: login.blade.php.bak)"
else
    warn "File $LOGIN_FILE tidak ditemukan, skip."
fi

# ── Update User.php avatar fallback ──────────────────────────
info "Update avatar fallback di User.php..."

USER_MODEL="app/Models/User.php"

if [ -f "$USER_MODEL" ]; then
    cp "$USER_MODEL" "${USER_MODEL}.bak"

    # Replace ui-avatars.com dengan asset lokal
    sed -i "s|'https://ui-avatars.com/api/?name=' . urlencode(\$this->name) . '&background=4f46e5&color=fff'|asset('assets/img/default-avatar.svg')|g" "$USER_MODEL"

    log "User.php avatar fallback updated"
else
    warn "File $USER_MODEL tidak ditemukan, skip."
fi

# ── Clear cache ───────────────────────────────────────────────
info "Clear Laravel cache..."
php artisan cache:clear
php artisan view:clear
php artisan config:clear
log "Cache cleared"

# ── Summary ───────────────────────────────────────────────────
echo ""
echo "========================================"
echo -e "${GREEN}  Selesai! Semua aset sudah offline.${NC}"
echo "========================================"
echo ""
echo "  File yang didownload:"
echo "  • public/assets/css/bootstrap.min.css"
echo "  • public/assets/css/bootstrap-icons.min.css"
echo "  • public/assets/js/jquery.min.js"
echo "  • public/assets/js/bootstrap.bundle.min.js"
echo "  • public/assets/fonts/bootstrap-icons.woff2"
echo "  • public/assets/fonts/bootstrap-icons.woff"
echo "  • public/assets/img/default-avatar.svg"
echo ""
echo "  Backup blade files tersimpan dengan ekstensi .bak"
echo ""