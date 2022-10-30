{if !empty($faqs)}
    <section id="faq">
        <div class="container">
            <div class="row">
                <div class="col s12 center-align">
                    <h2>Часто задаваемые вопросы</h2>
                </div>
            </div>
            <div class="row">
                <div class="col xl2 l3 m4 offset-m4 s6 offset-s3">
                    <div class="lazy q" data-src="{$THEME_IMG}/faq.svg"></div>
                </div>
                <div class="col xl10 l9 m12">
                    {foreach $faqs as $faq}
                        <div class="faq-block">
                            <div class="question collapsed">
                                <div class="text">{$faq['title']}</div>
                                <div class="action"></div>
                            </div>
                            <div class="answer">{$faq['text']}</div>
                        </div>
                    {/foreach}
                </div>
            </div>
        </div>
    </section>
{/if}
