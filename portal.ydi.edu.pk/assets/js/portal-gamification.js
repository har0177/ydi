/* YDI Student Portal — gamification engine
   Consumes real stats injected by PHP via data-stats JSON.
   No jQuery dependency. */
(function () {
    'use strict';

    function ready(fn) {
        if (document.readyState !== 'loading') fn();
        else document.addEventListener('DOMContentLoaded', fn);
    }

    var LEVELS = [
        { min: 0,   name: 'Newcomer',     emoji: '🌱' },
        { min: 10,  name: 'Explorer',     emoji: '🧭' },
        { min: 30,  name: 'Learner',      emoji: '📘' },
        { min: 80,  name: 'Practitioner', emoji: '🎯' },
        { min: 160, name: 'Achiever',     emoji: '🏅' },
        { min: 300, name: 'Master',       emoji: '🏆' }
    ];

    function levelFromXp(xp) {
        var current = LEVELS[0], next = null;
        for (var i = 0; i < LEVELS.length; i++) {
            if (xp >= LEVELS[i].min) current = LEVELS[i];
            else { next = LEVELS[i]; break; }
        }
        return { current: current, next: next };
    }

    function animateNumber(el, to, duration) {
        if (!el) return;
        duration = duration || 900;
        var t0 = performance.now();
        function tick(now) {
            var p = Math.min(1, (now - t0) / duration);
            var eased = 1 - Math.pow(1 - p, 3);
            el.textContent = Math.round(eased * to).toLocaleString();
            if (p < 1) requestAnimationFrame(tick);
        }
        requestAnimationFrame(tick);
    }

    function setRing(ringFill, pct) {
        var r = parseFloat(ringFill.getAttribute('r')) || 36;
        var c = 2 * Math.PI * r;
        ringFill.setAttribute('stroke-dasharray', c);
        ringFill.setAttribute('stroke-dashoffset', c);
        requestAnimationFrame(function () {
            ringFill.setAttribute('stroke-dashoffset', c * (1 - Math.max(0, Math.min(100, pct)) / 100));
        });
    }

    function buildBadges(s) {
        return [
            { id: 'welcome',   cat: 'welcome',    name: 'Welcome Aboard',  desc: 'Your YDI journey began',    icon: '👋', unlocked: true },
            { id: 'firstday',  cat: 'attendance', name: 'First Class',     desc: 'Attended your first class', icon: '🎒', unlocked: s.present >= 1 },
            { id: 'attend7',   cat: 'attendance', name: 'Week Regular',    desc: '7 days of attendance',      icon: '📅', unlocked: s.present >= 7 },
            { id: 'attend30',  cat: 'attendance', name: '30-Day Veteran',  desc: '30 days of attendance',     icon: '🗓️', unlocked: s.present >= 30 },
            { id: 'attend100', cat: 'attendance', name: 'Centurion',       desc: '100 days of attendance',    icon: '💯', unlocked: s.present >= 100 },
            { id: 'streak3',   cat: 'streak',     name: 'On a Roll',       desc: '3-day attendance streak',   icon: '🔥', unlocked: s.streak >= 3 },
            { id: 'streak7',   cat: 'streak',     name: 'Week Warrior',    desc: '7-day attendance streak',   icon: '⚡', unlocked: s.streak >= 7 },
            { id: 'streak14',  cat: 'streak',     name: 'Iron Streak',     desc: '14-day attendance streak',  icon: '🛡️', unlocked: s.streak >= 14 },
            { id: 'report1',   cat: 'reports',    name: 'First Report',    desc: 'First weekly evaluation',   icon: '📝', unlocked: s.reports >= 1 },
            { id: 'report5',   cat: 'reports',    name: 'Five Reports',    desc: '5 weekly evaluations',      icon: '📚', unlocked: s.reports >= 5 },
            { id: 'report20',  cat: 'reports',    name: 'Twenty Reports',  desc: '20 weekly evaluations',     icon: '🎓', unlocked: s.reports >= 20 },
            { id: 'avg70',     cat: 'score',      name: 'Top Performer',   desc: 'Average score 70%+',        icon: '🌟', unlocked: s.avg_score >= 70 },
            { id: 'best80',    cat: 'score',      name: 'High Scorer',     desc: 'Best score 80%+',           icon: '🥇', unlocked: s.best_score >= 80 },
            { id: 'best90',    cat: 'score',      name: 'Distinction',     desc: 'Best score 90%+',           icon: '💎', unlocked: s.best_score >= 90 },
            { id: 'rank1',     cat: 'score',      name: 'Class Champion',  desc: '#1 in class this week',     icon: '👑', unlocked: s.rank === 1 && s.reports > 0 },
            { id: 'fees',      cat: 'fee',        name: 'Fees Up to Date', desc: 'No outstanding dues',       icon: '✅', unlocked: s.fee_dues === 0 && s.fee_paid > 0 },
            { id: 'attend90',  cat: 'attendance', name: 'Reliable',        desc: 'Attendance ≥ 90%',          icon: '🎯', unlocked: s.attendance_pct >= 90 && (s.present + s.absent) >= 10 }
        ];
    }

    var CAT_STYLES = {
        welcome:    { bg: 'bg-violet-50',  fg: 'text-violet-600',  bd: 'border-violet-200' },
        attendance: { bg: 'bg-orange-50',  fg: 'text-orange-600',  bd: 'border-orange-200' },
        streak:     { bg: 'bg-amber-50',   fg: 'text-amber-600',   bd: 'border-amber-200' },
        reports:    { bg: 'bg-secondary-50', fg: 'text-secondary-600', bd: 'border-secondary-200' },
        score:      { bg: 'bg-yellow-50',  fg: 'text-yellow-700',  bd: 'border-yellow-200' },
        fee:        { bg: 'bg-emerald-50', fg: 'text-emerald-600', bd: 'border-emerald-200' }
    };

    function renderBadges(grid, badges, regNo) {
        grid.innerHTML = '';
        var key = 'ydi_seen_badges_' + regNo;
        var seen = {};
        try { seen = JSON.parse(localStorage.getItem(key) || '{}'); } catch (e) {}
        badges.forEach(function (b) {
            var st = CAT_STYLES[b.cat] || CAT_STYLES.attendance;
            var d = document.createElement('div');
            var locked = !b.unlocked;
            d.className = 'flex items-center gap-3 p-3 rounded-xl border transition '
                + (locked
                    ? 'bg-slate-50 border-slate-200 opacity-70'
                    : 'bg-white border-slate-200 hover:border-primary-200 hover:shadow-md');
            if (b.unlocked && !seen[b.id]) seen[b.id] = 1;
            var iconClasses = 'w-10 h-10 rounded-xl flex items-center justify-center text-lg flex-none border ' + (locked
                ? 'bg-slate-100 text-slate-400 border-slate-200'
                : st.bg + ' ' + st.fg + ' ' + st.bd);
            var indicator = locked
                ? '<div class="w-5 h-5 rounded-full border-2 border-slate-200 bg-slate-50 flex-none"></div>'
                : '<div class="w-5 h-5 rounded-full bg-emerald-500 text-white flex items-center justify-center text-[10px] font-bold flex-none">✓</div>';
            d.innerHTML =
                '<div class="' + iconClasses + '">' + b.icon + '</div>' +
                '<div class="flex-1 min-w-0">' +
                    '<p class="font-semibold text-sm ' + (locked ? 'text-slate-500' : 'text-slate-900') + ' leading-tight">' + b.name + '</p>' +
                    '<p class="text-xs text-slate-500 mt-0.5 leading-snug">' + b.desc + '</p>' +
                '</div>' +
                indicator;
            d.title = b.unlocked ? 'Unlocked: ' + b.name : 'Locked: ' + b.desc;
            grid.appendChild(d);
        });
        try { localStorage.setItem(key, JSON.stringify(seen)); } catch (e) {}
    }

    ready(function () {
        var root = document.getElementById('ydi-game');
        if (!root) return;

        var stats = {};
        try { stats = JSON.parse(root.getAttribute('data-stats') || '{}'); } catch (e) {}

        var s = {
            days_enrolled:  +stats.days_enrolled  || 0,
            present:        +stats.present        || 0,
            absent:         +stats.absent         || 0,
            attendance_pct: +stats.attendance_pct || 0,
            reports:        +stats.reports        || 0,
            avg_score:      +stats.avg_score      || 0,
            best_score:     +stats.best_score     || 0,
            latest_score:   +stats.latest_score   || 0,
            rank:           +stats.rank           || 0,
            fee_paid:       +stats.fee_paid       || 0,
            fee_dues:       +stats.fee_dues       || 0,
            streak:         +stats.streak         || 0,
            xp:             +stats.xp             || 0
        };

        var regNo = root.getAttribute('data-reg') || 'guest';
        var admissionDisplay = root.getAttribute('data-admission-display') || '';

        /* Hero / level */
        var lvl = levelFromXp(s.xp);
        var nextMin = lvl.next ? lvl.next.min : lvl.current.min;
        var prevMin = lvl.current.min;
        var span = Math.max(1, nextMin - prevMin);
        var pctIntoLevel = lvl.next ? Math.min(100, Math.round((s.xp - prevMin) / span * 100)) : 100;

        var tenureText;
        if (admissionDisplay) {
            tenureText = 'Member since ' + admissionDisplay + ' · ' + s.days_enrolled + ' days · ' + s.xp + ' XP';
        } else {
            tenureText = s.xp + ' XP earned';
        }
        var tenureEl = root.querySelector('[data-game-tenure]');
        if (tenureEl) tenureEl.textContent = tenureText;

        var levelEmoji = root.querySelector('[data-game-level-emoji]');
        if (levelEmoji) levelEmoji.textContent = lvl.current.emoji;
        var levelName = root.querySelector('[data-game-level-name]');
        if (levelName) levelName.textContent = lvl.current.name;
        var xpFill = root.querySelector('[data-game-xp-fill]');
        if (xpFill) requestAnimationFrame(function () { xpFill.style.width = pctIntoLevel + '%'; });
        var xpText = root.querySelector('[data-game-xp-text]');
        if (xpText) xpText.textContent = lvl.next
            ? s.xp + ' / ' + nextMin + ' XP · ' + (nextMin - s.xp) + ' to ' + lvl.next.name
            : 'Max level · ' + s.xp + ' XP';

        /* Attendance ring */
        var totalAttend = s.present + s.absent;
        var pctEl = root.querySelector('[data-game-pct]');
        if (pctEl) animateNumber(pctEl, s.attendance_pct, 1100);
        var ringFill = root.querySelector('[data-game-ring]');
        if (ringFill) setRing(ringFill, s.attendance_pct);
        var headline = root.querySelector('[data-game-attendance-headline]');
        var sub = root.querySelector('[data-game-attendance-sub]');
        if (headline) headline.textContent = s.present + ' present · ' + s.absent + ' absent';
        if (sub) sub.textContent = totalAttend === 0
            ? 'Awaiting your first class'
            : (totalAttend + ' total class days recorded');

        /* Streak */
        var streakEl = root.querySelector('[data-game-streak]');
        if (streakEl) animateNumber(streakEl, s.streak, 800);

        /* Stats row */
        var statMap = {
            '[data-game-latest]':  s.latest_score,
            '[data-game-avg]':     s.avg_score,
            '[data-game-best]':    s.best_score,
            '[data-game-reports]': s.reports,
            '[data-game-dues]':    s.fee_dues
        };
        Object.keys(statMap).forEach(function (sel) {
            var el = root.querySelector(sel);
            if (el) animateNumber(el, statMap[sel], 900);
        });
        var rankEl = root.querySelector('[data-game-rank]');
        if (rankEl) rankEl.textContent = s.rank > 0 ? '#' + s.rank : '—';

        /* Badges (may live outside #ydi-game now) */
        var grid = root.querySelector('[data-game-badges]') || document.querySelector('[data-game-badges]');
        if (grid) renderBadges(grid, buildBadges(s), regNo);
    });
})();
