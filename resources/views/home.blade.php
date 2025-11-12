@extends('layouts.app')

@section('title', 'Inicio')

@section('content')

    <section id="hero" class="hero-section">
        <div class="container">
            <h1>Transforma tu cuerpo. Transforma tu vida.</h1>
            <p>El mejor lugar para alcanzar tus metas de fitness con entrenamiento integral y personalizado.</p>
            <a href="/unete" class="primary-cta">Únete Ahora</a>
        </div>
    </section>

    <section id="servicios" class="services-section">
        <div class="container">
            <h2>💪 Nuestras Clases</h2>
            
            <div class="services-grid">
                
                <article class="service-card">
                    <img src="{{ asset('images/clase-yoga.jpg') }}" alt="Clase de Yoga" class="card-image">
                    <h3>Yoga & Flexibilidad</h3>
                    <p>Encuentra tu centro, reduce el estrés y mejora tu rango de movimiento.</p>
                    <a href="/clases/yoga" class="card-link">Más detalles</a>
                </article>
                
                <article class="service-card">
                    <img src="{{ asset('images/clase-crossfit.jpg') }}" alt="Clase de Cross-Training" class="card-image">
                    <h3>Cross-Training de Alta Intensidad</h3>
                    <p>Entrenamiento funcional diseñado para desafiar tus límites y obtener resultados rápidos.</p>
                    <a href="/clases/crossfit" class="card-link">Más detalles</a>
                </article>
                
                <article class="service-card">
                    <img src="{{ asset('images/clase-funcional.jpg') }}" alt="Clase de Entrenamiento de Fuerza" class="card-image">
                    <h3>Entrenamiento de Fuerza</h3>
                    <p>Sesiones guiadas para construir masa muscular, mejorar la postura y aumentar tu potencia.</p>
                    <a href="/clases/fuerza" class="card-link">Más detalles</a>
                </article>

                {{--<article class="service-card">
                    <img src="{{ asset('images/clase-crossfit.jpg') }}" alt="Clase de Boxeo Fitness" class="card-image">
                    <h3>Boxeo Fitness</h3>
                    <p>Combina cardio de alta energía y entrenamiento de boxeo para una sesión divertida.</p>
                    <a href="/clases/boxeo" class="card-link">Más detalles</a>
                </article>--}}
            </div>
            
        </div>
    </section>

    <section id="testimonios" class="testimonials-section">
        <div class="container">
            <h2>⭐ Lo que dicen nuestros miembros</h2>
            
            <blockquote cite="Ana G.">
                "Desde que estoy en CORPO, no solo perdí peso, sino que mi energía y mentalidad han cambiado por completo. ¡Es más que un gimnasio!"
            </blockquote>
            
            <a href="/testimonios" class="secondary-cta">Ver Más Historias</a>
        </div>
    </section>

    <section id="contacto-info" class="info-section">
         <div class="container">
            <h2>📍 Encuéntranos y entrena</h2>
            <address>
                calle 208 y 522, Abasto, Ciudad de La Plata.
            </address>
            <time datetime="Mo-Fr 06:00-22:00">Lunes a Viernes: 6:00 - 22:00</time>
            <br>
            <time datetime="Sa 08:00-14:00">Sábados: 8:00 - 14:00</time>
            <p style="margin-top: 15px;">Teléfono: (0221)[1111111]-CORPO</p>
         </div>
    </section>

@endsection
