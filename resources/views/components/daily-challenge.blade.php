@auth
<div x-data="dailyMission()" 
     x-init="init()"
     x-show="visible"
     class="fixed-top w-100 h-100 z-3"
     style="background: rgba(0,0,0,0.4); backdrop-filter: blur(4px); pointer-events: auto;"
     x-cloak
>
    <div class="d-flex align-items-center justify-content-center w-100 h-100">
        <div class="mission-container text-center p-4" @click.away="close()">
        <!-- Gift Box Animation Area -->
        <div class="gift-wrapper mb-4" :class="status">
            <div class="gift-box">
                <div class="gift-lid"></div>
                <div class="gift-body"></div>
                <div class="gift-ribbon"></div>
            </div>
            <div class="gift-content">
                <div class="mission-badge mb-2">🎁 {{ __('Mission du jour') }}</div>
                <h3 class="brand-font fw-bold text-white mb-3" x-text="mission.title"></h3>
                <p class="text-white opacity-90 fs-5 mb-4" x-text="mission.description"></p>
                <button @click="close()" class="btn btn-light rounded-pill px-5 fw-bold shadow-lg py-2">
                    {{ __('C\'est parti !') }}
                </button>
            </div>
        </div>
        </div>
    </div>
</div>

<style>
[x-cloak] { display: none !important; }

.gift-wrapper {
    position: relative;
    width: 200px;
    height: 200px;
    margin: 0 auto;
    cursor: pointer;
    transition: all 0.5s cubic-bezier(0.175, 0.885, 0.32, 1.275);
}

.gift-box {
    position: absolute;
    bottom: 0;
    left: 50%;
    transform: translateX(-50%);
    width: 120px;
    height: 100px;
    background: #d63031;
    border-radius: 8px;
    z-index: 2;
    transition: all 0.5s ease;
}

.gift-lid {
    position: absolute;
    top: -20px;
    left: -10px;
    width: 140px;
    height: 30px;
    background: #ff7675;
    border-radius: 8px;
    z-index: 3;
    transition: all 0.5s cubic-bezier(0.175, 0.885, 0.32, 1.275);
}

.gift-ribbon {
    position: absolute;
    top: -20px;
    left: 50%;
    transform: translateX(-50%);
    width: 30px;
    height: 120px;
    background: #fab1a0;
    z-index: 4;
}

.gift-ribbon::before {
    content: '';
    position: absolute;
    top: -20px;
    left: 50%;
    transform: translateX(-50%);
    width: 60px;
    height: 40px;
    border: 10px solid #fab1a0;
    border-radius: 50% 50% 0 0;
}

/* Animations States */
.gift-wrapper.bouncing .gift-box {
    animation: gift-bounce 1s infinite;
}

.gift-wrapper.opening .gift-lid {
    transform: translate(-20px, -100px) rotate(-20deg);
    opacity: 0;
}

.gift-wrapper.opened {
    width: 400px;
    height: auto;
}

.gift-wrapper.opened .gift-box {
    transform: translateX(-50%) scale(0);
    opacity: 0;
}

.gift-content {
    opacity: 0;
    transform: translateY(20px);
    transition: all 0.6s ease 0.3s;
    pointer-events: none;
}

.gift-wrapper.opened .gift-content {
    opacity: 1;
    transform: translateY(0);
    pointer-events: auto;
}

.mission-badge {
    display: inline-block;
    background: #ffeaa7;
    color: #d63031;
    font-weight: bold;
    padding: 5px 15px;
    border-radius: 50px;
    font-size: 0.9rem;
}

@keyframes gift-bounce {
    0%, 100% { transform: translateX(-50%) translateY(0); }
    50% { transform: translateX(-50%) translateY(-20px); }
}

@media (max-width: 576px) {
    .gift-wrapper.opened { width: 90vw; }
}
</style>

<script>
function dailyMission() {
    return {
        visible: false,
        status: 'bouncing',
        mission: {},
        
        init() {
            if (sessionStorage.getItem('mission_v2_dismissed')) return;

            fetch('{{ route("challenge.daily") }}')
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        this.mission = data.challenge;
                        this.visible = true;
                        
                        // Auto open after 1.5s
                        setTimeout(() => {
                            this.status = 'opening';
                            setTimeout(() => {
                                this.status = 'opened';
                                if (window.confetti) {
                                    confetti({
                                        particleCount: 50,
                                        spread: 60,
                                        origin: { y: 0.6 }
                                    });
                                }
                            }, 500);
                        }, 1500);
                    }
                });
        },
        
        close() {
            this.visible = false;
            sessionStorage.setItem('mission_v2_dismissed', 'true');
        }
    }
}
</script>
@endauth
