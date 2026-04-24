@extends('Frontend.layouts.app')
@section('title', '')

@push('styles')
    <style>

    </style>
@endpush

@section('main')
    {{-- about us section --}}
    <section class="about-section">
        <div class="container">

            <h2 class="about-heading text-center">About Us</h2>

            <ol>
                <li class="li-section">Pro-talk is a virtual learning platform dedicated to the science of nutrition for
                    practising clinical dieticians and nutritionists. Pro-talk helps nutrition professionals to apply
                    evidence-based dietetics practices through case-study discussions. This platform brings together
                    nutritionists at different stages of their careers to explore, enable them to share and learn from the
                    latest science and rich experiences. It fosters collaborative learning environment that blends
                    enthusiasm and trust among practicing dieticians</li>

                <li class="li-section mt-3">We believe, Case-based active discussions from the clinical settings would help
                    develop dedicated network for practicing dieticians to resolve their day-to-day clinical dilemmas or
                    deal with crossroads, improve their academic achievement, develop advanced skills and empower them with
                    the latest nutrition information. </li>

                <li class="li-section mt-3">In current times of AI technology, one can access latest knowledge in nutrition,
                    however, delivering skills-based, flexible and personalized learning experience is the aim of this
                    platform.
                </li>
                <p class="p1 mt-3"> To stay up-to-date with evidence-based nutrition and clinical practices, Pro-talk offers
                    the following features/services </p>
                <p class="li-none p1"><b>1. Webcast Connect</b></p>
                <p class="li-none p1"><b>2. Consult experts for your queries</b></p>
                <p class="li-none p1"><b>3. Exchange of opinions and experiences </b></p>
                <p class="li-none p1"><b>4. Resources</b></p>

                <li class="li-section highlight mt-3"><b>Webcast Connect:</b> </li>
                <p class="p1">Live webcasts and A rich repository of unique case studies</p>
                <p class="p1">Key opinion leaders in clinical nutrition share case presentations with their experience
                    and learning while managing difficult cases. This is an excellent experiential learning option for
                    Nutritionists to obtain a practical and enjoyable approach to nutrition through the sound application of
                    nutrition practices. </p>

                <li class="li-section highlight mt-3"><b>Consult experts for your queries:</b> </li>
                <p class="p1">A forum for Clinical Dieticians to put up their case-related queries, clinical dilemmas or
                    how to deal with crossroads for a particular case. We would have experts responding to these queries
                    virtually. In this process, everyone gains from these insights. </p>

                <li class="li-section mt-3"><b>We welcome case studies on the following topics</b> </li>
                <p class="p1">- Nutrition in Perioperative cases</p>
                <p class="p1">- Nutrition in Critical Illness</p>
                <p class="p1">- Nutrition in hepatic conditions</p>
                <p class="p1">- Nutrition in cancer patients</p>
                <p class="p1">- NutNutrition in major trauma/injuries</p>
                <p class="p1">- Nutrition in renal diseases/renal failure</p>
                <p class="p1">- Nutrition in respiratory illnesses</p>

                <!-- <li class="li-section mt-3"><b>Our Expert:</b> </li>
                                        <p class="p1">We have panel of experts for each topic who would address your queries</p>
                                        <p class="p1">Nutrition in Critical Illness: <b>Dr Radha Reddy, Dr Eline Canday</b> </p>
                                        <p class="p1">Nutrition in Hepatic conditions:  <b>Ms Zamurrud Patel, Dr. Daphnee Lovesley</b> </p>
                                        <p class="p1">Nutrition in Perioperative cases: <b>Dr Haritha- Shyam, Ms Ritika Samaddar,</b> </p>
                                        <p class="p1"> Nutrition in Cancer: <b>Ms Bakti Samant, Mr. T. Shivshankar</b> </p>
                                        <p class="p1">Nutrition in respiratory illnesses: <b>Dr Anita Jatana, Dr Meenakshi Bajaj</b> </p> -->

                <li class="li-section highlight mt-3"><b>Exchange of opinions and experiences: </b> </li>
                <p class="p1">An interactive open discussion forum for Clinical Dieticians to upload unique cases,
                    clinical dilemmas or crossroads from their practice. Fellow Clinical Dieticians who wish to provide
                    their opinions, add value or share their experiences would contribute to the discussion. Experts would
                    provide final comments and closing remarks on a specific query or a topic of the discussion. </p>

                <li class="li-section highlight mt-3"><b>Resources: </b> </li>
                <p class="p1">The resource bank includes – conference key takeaways, conference presentation </p>

            </ol>

            {{-- <div class="about-content">

                <ol>
                    <li>
                        Pro-talk is a virtual learning platform dedicated to the science of nutrition for practising
                        clinical dieticians and nutritionists. Pro-talk helps nutrition professionals to apply
                        evidence-based dietetics practices through case-study discussions. This platform brings together
                        nutritionists at different stages of their careers to explore, enable them to share and learn from
                        the latest science and rich experiences. It fosters collaborative learning environment that blends
                        enthusiasm and trust among practicing dieticians.
                    </li>

                    <li>
                        We believe, Case-based active discussions from the clinical settings would help develop dedicated
                        network for practicing dieticians to resolve their day-to-day clinical dilemmas or deal with
                        crossroads, improve their academic achievement, develop advanced skills and empower them with the
                        latest nutrition information.
                    </li>

                    <li>
                        In current times of AI technology, one can access latest knowledge in nutrition, however, delivering
                        skills-based, flexible and personalized learning experience is the aim of this platform.
                    </li>
                </ol>

                <p>
                    To stay up-to-date with evidence-based nutrition and clinical practices, Pro-talk offers the following
                    features/services
                </p>

                <ol class="mt-3">
                    <li><strong>Webcast Connect</strong></li>
                    <li><strong>Consult experts for your queries</strong></li>
                    <li><strong>Exchange of opinions and experiences</strong></li>
                    <li><strong>Resources</strong></li>
                </ol>

                <div class="about-sub-content">

                    <p><strong>Webcast Connect:</strong><br>
                        Live webcasts and a rich repository of unique case studies
                    </p>

                    <p>
                        Key opinion leaders in clinical nutrition share case presentations with their experience and
                        learning while managing difficult cases. This is an excellent experiential learning option for
                        Nutritionists to obtain a practical and enjoyable approach to nutrition through the sound
                        application of nutrition practices.
                    </p>

                    <p><strong>Consult experts for your queries:</strong><br>
                        A forum for Clinical Dieticians to put up their case-related queries, clinical dilemmas or how to
                        deal with crossroads for a particular case. We would have experts responding to these queries
                        virtually. In this process, everyone gains from these insights.
                    </p>

                    <p><strong>We welcome case studies on the following topics</strong></p>

                    <ul>
                        <li>Nutrition in Perioperative cases</li>
                        <li>Nutrition in Critical Illness</li>
                        <li>Nutrition in hepatic conditions</li>
                        <li>Nutrition in cancer patients</li>
                        <li>Nutrition in major trauma/injuries</li>
                        <li>Nutrition in renal diseases/renal failure</li>
                        <li>Nutrition in respiratory illnesses</li>
                    </ul>

                    <p><strong>Exchange of opinions and experiences:</strong><br>
                        An interactive open discussion forum for Clinical Dieticians to upload unique cases, clinical
                        dilemmas or crossroads from their practice. Fellow Clinical Dieticians who wish to provide their
                        opinions, add value or share their experiences would contribute to the discussion. Experts would
                        provide final comments and closing remarks on a specific query or a topic of the discussion.
                    </p>

                    <p><strong>Resources:</strong><br>
                        The resource bank includes – conference key takeaways, conference presentation
                    </p>

                </div>

            </div> --}}
        </div>
    </section>
@endsection

@push('scripts')
    <script></script>
@endpush
