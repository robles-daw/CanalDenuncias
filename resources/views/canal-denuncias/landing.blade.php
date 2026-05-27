<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Canal de denuncias</title>
    @php($themeAccentDeep = '#7f3212')
    @include('partials.theme-head')
    <style>
        .hero {
            position: relative;
            min-height: calc(100vh - 82px);
            padding: 38px 44px 46px;
            border-radius: var(--radius-xl);
            overflow: hidden;
        }

        .hero::before {
            content: "";
            position: absolute;
            inset: 0;
            background:
                radial-gradient(circle at 8% 10%, rgba(178,74,27,0.11), transparent 0 24%),
                radial-gradient(circle at 78% 24%, rgba(178,74,27,0.06), transparent 0 18%),
                radial-gradient(circle at 90% 82%, rgba(127,50,18,0.08), transparent 0 16%);
            pointer-events: none;
        }

        .hero::after {
            content: "";
            position: absolute;
            top: -12%;
            right: 8%;
            width: 42%;
            height: 124%;
            border-radius: 42% 58% 57% 43% / 38% 36% 64% 62%;
            background:
                radial-gradient(circle at 28% 30%, rgba(255,255,255,0.44), transparent 0 28%),
                linear-gradient(160deg, rgba(178,74,27,0.16), rgba(127,50,18,0.06) 58%, rgba(255,255,255,0.12));
            opacity: 0.95;
            filter: blur(0.5px);
        }

        .hero-grid {
            position: relative;
            z-index: 1;
            display: grid;
            grid-template-columns: minmax(0, 1.1fr) minmax(320px, 0.9fr);
            gap: 40px;
            align-items: stretch;
            min-height: 100%;
        }

        .eyebrow {
            background: rgba(255, 255, 255, 0.88);
        }

        .content {
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            min-height: 100%;
        }

        h1 {
            margin-top: 24px;
            width: 100%;
            max-width: none;
            font-size: 4vw;
            line-height: 0.89;
            background: linear-gradient(180deg, var(--ink) 0%, color-mix(in srgb, var(--ink) 70%, var(--accent-deep)) 100%);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
        }

        .lead {
            max-width: 62ch;
            margin-top: 26px;
            color: var(--muted);
            font-size: clamp(1.05rem, 1.8vw, 1.26rem);
            line-height: 1.72;
        }

        .legal-strip {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 22px;
            margin-top: 44px;
            padding-top: 28px;
            border-top: 1px solid rgba(24, 33, 43, 0.10);
        }

        .legal-strip article strong {
            display: block;
            margin-bottom: 10px;
            color: var(--accent-deep);
            font-size: 0.82rem;
            letter-spacing: 0.08em;
            text-transform: uppercase;
        }

        .legal-strip article p {
            margin: 0;
            color: var(--muted);
            line-height: 1.7;
        }

        .side {
            position: relative;
            display: flex;
            align-items: flex-end;
            justify-content: flex-end;
            min-height: 100%;
        }

        .side-panel {
            position: relative;
            width: min(430px, 100%);
            margin-top: auto;
            padding: 30px 30px 28px;
            border-radius: var(--radius-lg);
        }

        .side-panel h2 {
            font-family: "Fraunces", serif;
            font-size: 1.55rem;
            line-height: 1.05;
            font-weight: 500;
        }

        .side-panel p {
            margin: 14px 0 0;
            color: var(--muted);
            line-height: 1.72;
        }

        .side-meta {
            display: grid;
            gap: 14px;
            margin-top: 26px;
            padding-top: 22px;
            border-top: 1px solid rgba(24, 33, 43, 0.10);
        }

        .side-meta div strong {
            display: block;
            margin-bottom: 4px;
            font-size: 0.82rem;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            color: var(--accent-deep);
        }

        .side-meta div span {
            color: var(--muted);
            line-height: 1.65;
        }

        @media (max-width: 1100px) {
            .hero {
                min-height: auto;
            }

            .hero-grid {
                grid-template-columns: 1fr;
            }

            .side {
                justify-content: flex-start;
            }

            .hero::after {
                width: 70%;
                height: 46%;
                top: auto;
                bottom: -10%;
                right: -8%;
            }
        }

        @media (max-width: 820px) {
            .legal-strip {
                grid-template-columns: 1fr;
                gap: 18px;
            }

            h1 {
                max-width: none;
            }
        }

        @media (max-width: 640px) {
            .page {
                padding: 14px 14px 34px;
            }

            .hero {
                padding: 24px 22px 28px;
                border-radius: 24px;
            }

            .side-panel {
                padding: 22px 20px;
                border-radius: 22px;
            }

            h1 {
                margin-top: 20px;
                font-size: clamp(3.2rem, 18vw, 5rem);
                line-height: 0.92;
            }

            .lead {
                margin-top: 20px;
            }
        }
    </style>
</head>
<body>
    <main class="page">
        <section class="hero glass">
            <div class="hero-grid">
                <div class="content">
                    <div>
                        <span class="eyebrow">Canal de denuncias</span>
                        <h1>Comunicación segura, reservada y conforme.</h1>
                        <p class="lead">
                            Este canal está destinado a la recepción y tratamiento de comunicaciones relacionadas con posibles incumplimientos normativos, conductas contrarias al código ético, riesgos relevantes o hechos que deban ser objeto de revisión interna, con las garantías de confidencialidad, trazabilidad y protección aplicables en cada caso.
                        </p>
                    </div>

                    <section class="legal-strip">
                        <article>
                            <strong>Uso adecuado</strong>
                            <p>Las comunicaciones deben formularse de buena fe y sobre hechos o indicios razonables, evitando usos ajenos a la finalidad del canal.</p>
                        </article>

                        <article>
                            <strong>Confidencialidad</strong>
                            <p>La información remitida será tratada con estricta reserva y únicamente por las personas autorizadas para su gestión y análisis.</p>
                        </article>

                        <article>
                            <strong>Seguimiento</strong>
                            <p>Cada comunicación genera un código que permite consultar su estado sin exponer el contenido del expediente.</p>
                        </article>
                    </section>
                </div>

                <aside class="side">
                    <section class="side-panel glass">
                        <h2>Acceso individualizado por empresa</h2>
                        <p>
                            La entrada al canal se realiza mediante la URL específica facilitada por cada entidad. Cada empresa dispone de su propio entorno de recepción, su configuración visual y su panel privado de gestión.
                        </p>

                        <div class="side-meta">
                            <div>
                                <strong>Entorno diferenciado</strong>
                                <span>Cada acceso opera de forma separada para mantener la identidad, la documentación y la gestión del canal de cada empresa.</span>
                            </div>
                            <div>
                                <strong>Marco legal</strong>
                                <span>La conservación de la información y el tratamiento de datos se rigen por la política de privacidad y por la normativa aplicable al sistema.</span>
                            </div>
                        </div>
                    </section>
                </aside>
            </div>
        </section>
    </main>
</body>
</html>
