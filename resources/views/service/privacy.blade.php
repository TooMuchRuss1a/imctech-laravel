@extends('layouts.landing.app')

@section('content')

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md">
                <div class="card">
                    <div class="card-header">{{ __('Политика в отношении обработки персональных данных') }}</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success m-2" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
                        @if (session('error'))
                            <div class="alert alert-warning m-2" role="alert">
                                {{ session('error') }}
                            </div>
                        @endif
                        <div><strong>1 Общие положения</strong></div>
                        <div style="padding-left:0.8rem">
                            <div>Настоящая политика обработки персональных данных составлена в соответствии с
                                требованиями Федерального закона от 27.07.2006. №152-ФЗ «О персональных данных» (далее -
                                Закон о персональных данных) и определяет порядок обработки персональных данных и меры
                                по обеспечению безопасности персональных данных, предпринимаемые Демьяновым Виктором
                                Витальевичем (далее – Оператор).
                            </div>
                            <div>1.1 Оператор ставит своей важнейшей целью и условием осуществления своей деятельности
                                соблюдение прав и свобод человека и гражданина при обработке его персональных данных, в
                                том числе защиты прав на неприкосновенность частной жизни, личную и семейную тайну.
                            </div>
                            <div>1.2 Настоящая политика Оператора в отношении обработки персональных данных (далее –
                                Политика) применяется ко всей информации, которую Оператор может получить о посетителях
                                веб-сайта https://imctech.ru.
                            </div>
                        </div>
                        <p>

                        <div><strong>2 Основные понятия, используемые в Политике</strong></div>
                        <div style="padding-left: 0.8rem">
                            <div>2.1 Автоматизированная обработка персональных данных – обработка персональных данных с
                                помощью средств вычислительной техники.
                            </div>
                            <div>2.2 Блокирование персональных данных – временное прекращение обработки персональных
                                данных (за исключением случаев, если обработка необходима для уточнения персональных
                                данных).
                            </div>
                            <div>2.3 Веб-сайт – совокупность графических и информационных материалов, а также программ
                                для ЭВМ и баз данных, обеспечивающих их доступность в сети интернет по сетевому адресу
                                https://imctech.ru.
                            </div>
                            <div>2.4 Информационная система персональных данных — совокупность содержащихся в базах
                                данных персональных данных, и обеспечивающих их обработку информационных технологий и
                                технических средств.
                            </div>
                            <div>2.5 Обезличивание персональных данных — действия, в результате которых невозможно
                                определить без использования дополнительной информации принадлежность персональных
                                данных конкретному Пользователю или иному субъекту персональных данных.
                            </div>
                            <div>2.6 Обработка персональных данных – любое действие (операция) или совокупность действий
                                (операций), совершаемых с использованием средств автоматизации или без использования
                                таких средств с персональными данными, включая сбор, запись, систематизацию, накопление,
                                хранение, уточнение (обновление, изменение), извлечение, использование, передачу
                                (распространение, предоставление, доступ), обезличивание, блокирование, удаление,
                                уничтожение персональных данных.
                            </div>
                            <div>2.7 Оператор – государственный орган, муниципальный орган, юридическое или физическое
                                лицо, самостоятельно или совместно с другими лицами организующие и (или) осуществляющие
                                обработку персональных данных, а также определяющие цели обработки персональных данных,
                                состав персональных данных, подлежащих обработке, действия (операции), совершаемые с
                                персональными данными.
                            </div>
                            <div>2.8 Персональные данные – любая информация, относящаяся прямо или косвенно к
                                определенному или определяемому Пользователю веб-сайта https://imctech.ru.
                            </div>
                            <div>2.9 Персональные данные, разрешенные субъектом персональных данных для распространения,
                                - персональные данные, доступ неограниченного круга лиц к которым предоставлен субъектом
                                персональных данных путем дачи согласия на обработку персональных данных, разрешенных
                                субъектом персональных данных для распространения в порядке, предусмотренном Законом о
                                персональных данных (далее - персональные данные, разрешенные для распространения).
                            </div>
                            <div>2.10 Пользователь – любой посетитель веб-сайта https://imctech.ru.</div>
                            <div>2.11 Предоставление персональных данных – действия, направленные на раскрытие
                                персональных данных определенному лицу или определенному кругу лиц.
                            </div>
                            <div>2.12 Распространение персональных данных – любые действия, направленные на раскрытие
                                персональных данных неопределенному кругу лиц (передача персональных данных) или на
                                ознакомление с персональными данными неограниченного круга лиц, в том числе
                                обнародование персональных данных в средствах массовой информации, размещение в
                                информационно-телекоммуникационных сетях или предоставление доступа к персональным
                                данным каким-либо иным способом.
                            </div>
                            <div>2.13 Трансграничная передача персональных данных – передача персональных данных на
                                территорию иностранного государства органу власти иностранного государства, иностранному
                                физическому или иностранному юридическому лицу.
                            </div>
                            <div>2.14 Уничтожение персональных данных – любые действия, в результате которых
                                персональные данные уничтожаются безвозвратно с невозможностью дальнейшего
                                восстановления содержания персональных данных в информационной системе персональных
                                данных и (или) уничтожаются материальные носители персональных данных.
                            </div>
                        </div>
                        <p>

                        <div><strong>3 Основные права и обязанности Оператора</strong></div>
                        <div style="padding-left: 0.8rem">
                            <div>3.1 Оператор имеет право:</div>
                            <div>– получать от субъекта персональных данных достоверные информацию и/или документы,
                                содержащие персональные данные;
                            </div>
                            <div>– в случае отзыва субъектом персональных данных согласия на обработку персональных
                                данных Оператор вправе продолжить обработку персональных данных без согласия субъекта
                                персональных данных при наличии оснований, указанных в Законе о персональных данных;
                            </div>
                            <div>– самостоятельно определять состав и перечень мер, необходимых и достаточных для
                                обеспечения выполнения обязанностей, предусмотренных Законом о персональных данных и
                                принятыми в соответствии с ним нормативными правовыми актами, если иное не предусмотрено
                                Законом о персональных данных или другими федеральными законами.
                            </div>
                            <div>3.2 Оператор обязан:</div>
                            <div>– предоставлять субъекту персональных данных по его просьбе информацию, касающуюся
                                обработки его персональных данных;
                            </div>
                            <div>– организовывать обработку персональных данных в порядке, установленном действующим
                                законодательством РФ;
                            </div>
                            <div>– отвечать на обращения и запросы субъектов персональных данных и их законных
                                представителей в соответствии с требованиями Закона о персональных данных;
                            </div>
                            <div>– сообщать в уполномоченный орган по защите прав субъектов персональных данных по
                                запросу этого органа необходимую информацию в течение 30 дней с даты получения такого
                                запроса;
                            </div>
                            <div>– публиковать или иным образом обеспечивать неограниченный доступ к настоящей Политике
                                в отношении обработки персональных данных;
                            </div>
                            <div>– принимать правовые, организационные и технические меры для защиты персональных данных
                                от неправомерного или случайного доступа к ним, уничтожения, изменения, блокирования,
                                копирования, предоставления, распространения персональных данных, а также от иных
                                неправомерных действий в отношении персональных данных;
                            </div>
                            <div>– прекратить передачу (распространение, предоставление, доступ) персональных данных,
                                прекратить обработку и уничтожить персональные данные в порядке и случаях,
                                предусмотренных Законом о персональных данных;
                            </div>
                            <div>– исполнять иные обязанности, предусмотренные Законом о персональных данных.</div>
                        </div>
                        <p>

                        <div><strong>4 Основные права и обязанности субъектов персональных данных</strong></div>
                        <div style="padding-left: 0.8rem">
                            <div>4.1 Субъекты персональных данных имеют право:</div>
                            <div>– получать информацию, касающуюся обработки его персональных данных, за исключением
                                случаев, предусмотренных федеральными законами. Сведения предоставляются субъекту
                                персональных данных Оператором в доступной форме, и в них не должны содержаться
                                персональные данные, относящиеся к другим субъектам персональных данных, за исключением
                                случаев, когда имеются законные основания для раскрытия таких персональных данных.
                                Перечень информации и порядок ее получения установлен Законом о персональных данных;
                            </div>
                            <div>– требовать от оператора уточнения его персональных данных, их блокирования или
                                уничтожения в случае, если персональные данные являются неполными, устаревшими,
                                неточными, незаконно полученными или не являются необходимыми для заявленной цели
                                обработки, а также принимать предусмотренные законом меры по защите своих прав;
                            </div>
                            <div>– выдвигать условие предварительного согласия при обработке персональных данных в целях
                                продвижения на рынке товаров, работ и услуг;
                            </div>
                            <div>– на отзыв согласия на обработку персональных данных;</div>
                            <div>– обжаловать в уполномоченный орган по защите прав субъектов персональных данных или в
                                судебном порядке неправомерные действия или бездействие Оператора при обработке его
                                персональных данных;
                            </div>
                            <div>– на осуществление иных прав, предусмотренных законодательством РФ.</div>
                            <div>4.2 Субъекты персональных данных обязаны:</div>
                            <div>– предоставлять Оператору достоверные данные о себе;</div>
                            <div>– сообщать Оператору об уточнении (обновлении, изменении) своих персональных данных.
                            </div>
                            <div>4.3 Лица, передавшие Оператору недостоверные сведения о себе, либо сведения о другом
                                субъекте персональных данных без согласия последнего, несут ответственность в
                                соответствии с законодательством РФ.
                            </div>
                        </div>
                        <p>

                        <div><strong>5 Оператор может обрабатывать следующие персональные данные Пользователя</strong>
                        </div>
                        <div style="padding-left: 0.8rem">
                            <div>5.1 Фамилия, имя, отчество.</div>
                            <div>5.2 Электронный адрес.</div>
                            <div>5.3 Сведения об IP-адресе, файлах cookie, операционной системе, браузере и
                                местаположении.
                            </div>
                            <div>5.4 Ссылки на профили в социальных сетях.</div>
                            <div>5.5 Также на сайте происходит сбор и обработка обезличенных данных о посетителях (в
                                т.ч. файлов «cookie») с помощью сервисов интернет-статистики (Яндекс Метрика и Гугл
                                Аналитика и других).
                            </div>
                            <div>5.6 Вышеперечисленные данные далее по тексту Политики объединены общим понятием
                                Персональные данные.
                            </div>
                            <div>5.7 Обработка специальных категорий персональных данных, касающихся расовой,
                                национальной принадлежности, политических взглядов, религиозных или философских
                                убеждений, интимной жизни, Оператором не осуществляется.
                            </div>
                            <div>5.8 Обработка персональных данных, разрешенных для распространения, из числа
                                специальных категорий персональных данных, указанных в ч. 1 ст. 10 Закона о персональных
                                данных, допускается, если соблюдаются запреты и условия, предусмотренные ст. 10.1 Закона
                                о персональных данных.
                            </div>
                            <div>5.9 Согласие Пользователя на обработку персональных данных, разрешенных для
                                распространения, оформляется отдельно от других согласий на обработку его персональных
                                данных. При этом соблюдаются условия, предусмотренные, в частности, ст. 10.1 Закона о
                                персональных данных. Требования к содержанию такого согласия устанавливаются
                                уполномоченным органом по защите прав субъектов персональных данных.
                            </div>
                            <div>5.9.1 Согласие на обработку персональных данных, разрешенных для распространения,
                                Пользователь предоставляет Оператору непосредственно.
                            </div>
                            <div>5.9.2 Оператор обязан в срок не позднее трех рабочих дней с момента получения
                                указанного согласия Пользователя опубликовать информацию об условиях обработки, о
                                наличии запретов и условий на обработку неограниченным кругом лиц персональных данных,
                                разрешенных для распространения.
                            </div>
                            <div>5.9.3 Передача (распространение, предоставление, доступ) персональных данных,
                                разрешенных субъектом персональных данных для распространения, должна быть прекращена в
                                любое время по требованию субъекта персональных данных. Данное требование должно
                                включать в себя фамилию, имя, отчество (при наличии), контактную информацию (номер
                                телефона, адрес электронной почты или почтовый адрес) субъекта персональных данных, а
                                также перечень персональных данных, обработка которых подлежит прекращению. Указанные в
                                данном требовании персональные данные могут обрабатываться только Оператором, которому
                                оно направлено.
                            </div>
                            <div>5.9.4 Согласие на обработку персональных данных, разрешенных для распространения,
                                прекращает свое действие с момента поступления Оператору требования, указанного в п.
                                5.9.3 настоящей Политики в отношении обработки персональных данных.
                            </div>
                        </div>
                        <p>

                        <div><strong>6 Принципы обработки персональных данных</strong></div>
                        <div style="padding-left: 0.8rem">
                            <div>6.1 Обработка персональных данных осуществляется на законной и справедливой основе.
                            </div>
                            <div>6.2 Обработка персональных данных ограничивается достижением конкретных, заранее
                                определенных и законных целей. Не допускается обработка персональных данных,
                                несовместимая с целями сбора персональных данных.
                            </div>
                            <div>6.3 Не допускается объединение баз данных, содержащих персональные данные, обработка
                                которых осуществляется в целях, несовместимых между собой.
                            </div>
                            <div>6.4 Обработке подлежат только персональные данные, которые отвечают целям их
                                обработки.
                            </div>
                            <div>6.5 Содержание и объем обрабатываемых персональных данных соответствуют заявленным
                                целям обработки. Не допускается избыточность обрабатываемых персональных данных по
                                отношению к заявленным целям их обработки.
                            </div>
                            <div>6.6 При обработке персональных данных обеспечивается точность персональных данных, их
                                достаточность, а в необходимых случаях и актуальность по отношению к целям обработки
                                персональных данных. Оператор принимает необходимые меры и/или обеспечивает их принятие
                                по удалению или уточнению неполных или неточных данных.
                            </div>
                            <div>6.7 Хранение персональных данных осуществляется в форме, позволяющей определить
                                субъекта персональных данных, не дольше, чем этого требуют цели обработки персональных
                                данных, если срок хранения персональных данных не установлен федеральным законом,
                                договором, стороной которого, выгодоприобретателем или поручителем по которому является
                                субъект персональных данных. Обрабатываемые персональные данные уничтожаются либо
                                обезличиваются по достижении целей обработки или в случае утраты необходимости в
                                достижении этих целей, если иное не предусмотрено федеральным законом.
                            </div>
                        </div>
                        <p>

                        <div><strong>7 Цели обработки персональных данных</strong></div>
                        <div style="padding-left: 0.8rem">
                            <div>7.1 Цель обработки персональных данных Пользователя:</div>
                            <div>– информирование Пользователя посредством отправки электронных писем;</div>
                            <div>– предоставление доступа Пользователю к сервисам, информации и/или материалам,
                                содержащимся на веб-сайте httpsː//imctech.ru;
                            </div>
                            <div>7.2 Также Оператор имеет право направлять Пользователю уведомления о новых продуктах и
                                услугах, специальных предложениях и различных событиях. Пользователь всегда может
                                отказаться от получения информационных сообщений, направив Оператору письмо на адрес
                                электронной почты support@imctech.ru с пометкой «Отказ от уведомлений о новых продуктах
                                и услугах и специальных предложениях».
                            </div>
                            <div>7.3 Обезличенные данные Пользователей, собираемые с помощью сервисов
                                интернет-статистики, служат для сбора информации о действиях Пользователей на сайте,
                                улучшения качества сайта и его содержания.
                            </div>
                        </div>
                        <p>

                        <div><strong>8 Правовые основания обработки персональных данных</strong></div>
                        <div style="padding-left: 0.8rem">
                            <div>8.1 Правовыми основаниями обработки персональных данных Оператором являются:</div>
                            <div>– договоры, заключаемые между оператором и субъектом персональных данных;</div>
                            <div>– Федеральный закон от 27 июля 2006 г. № 149-ФЗ «Об информации, информационных
                                технологиях и о защите информации»;
                            </div>
                            <div>– Федеральный закон от 27 июля 2006 г. № 152-ФЗ «О персональных данных»;</div>
                            <div>– Приказ Роскомнадзора от 5 сентября 2013 г. № 996 «Об утверждении требований и методов
                                по обезличиванию персональных данных»;
                            </div>
                            <div>– федеральные законы, иные нормативно-правовые акты в сфере защиты персональных
                                данных;
                            </div>
                            <div>– согласия Пользователей на обработку их персональных данных, на обработку персональных
                                данных, разрешенных для распространения.
                            </div>
                            <div>8.2 Оператор обрабатывает персональные данные Пользователя только в случае их
                                заполнения и/или отправки Пользователем самостоятельно через специальные формы,
                                расположенные на сайте https://imctech.ru или направленные Оператору посредством
                                электронной почты. Заполняя соответствующие формы и/или отправляя свои персональные
                                данные Оператору, Пользователь выражает свое согласие с данной Политикой.
                            </div>
                            <div>8.3 Оператор обрабатывает обезличенные данные о Пользователе в случае, если это
                                разрешено в настройках браузера Пользователя (включено сохранение файлов «cookie» и
                                использование технологии JavaScript).
                            </div>
                            <div>8.4 Субъект персональных данных самостоятельно принимает решение о предоставлении его
                                персональных данных и дает согласие свободно, своей волей и в своем интересе.
                            </div>
                        </div>
                        <p>

                        <div><strong>9 Условия обработки персональных данных</strong></div>
                        <div style="padding-left: 0.8rem">
                            <div>9.1 Обработка персональных данных осуществляется с согласия субъекта персональных
                                данных на обработку его персональных данных.
                            </div>
                            <div>9.2 Обработка персональных данных необходима для достижения целей, предусмотренных
                                международным договором Российской Федерации или законом, для осуществления возложенных
                                законодательством Российской Федерации на оператора функций, полномочий и обязанностей.
                            </div>
                            <div>9.3 Обработка персональных данных необходима для осуществления правосудия, исполнения
                                судебного акта, акта другого органа или должностного лица, подлежащих исполнению в
                                соответствии с законодательством Российской Федерации об исполнительном производстве.
                            </div>
                            <div>9.4 Обработка персональных данных необходима для исполнения договора, стороной которого
                                либо выгодоприобретателем или поручителем по которому является субъект персональных
                                данных, а также для заключения договора по инициативе субъекта персональных данных или
                                договора, по которому субъект персональных данных будет являться выгодоприобретателем
                                или поручителем.
                            </div>
                            <div>9.5 Обработка персональных данных необходима для осуществления прав и законных
                                интересов оператора или третьих лиц либо для достижения общественно значимых целей при
                                условии, что при этом не нарушаются права и свободы субъекта персональных данных.
                            </div>
                            <div>9.6 Осуществляется обработка персональных данных, доступ неограниченного круга лиц к
                                которым предоставлен субъектом персональных данных либо по его просьбе (далее –
                                общедоступные персональные данные).
                            </div>
                            <div>9.7 Осуществляется обработка персональных данных, подлежащих опубликованию или
                                обязательному раскрытию в соответствии с федеральным законом.
                            </div>
                        </div>
                        <p>

                        <div><strong>10 Порядок сбора, хранения, передачи и других видов обработки персональных
                                данных</strong></div>
                        <div style="padding-left: 0.8rem">
                            <div>Безопасность персональных данных, которые обрабатываются Оператором, обеспечивается
                                путем реализации правовых, организационных и технических мер, необходимых для выполнения
                                в полном объеме требований действующего законодательства в области защиты персональных
                                данных.
                            </div>
                            <div>10.1 Оператор обеспечивает сохранность персональных данных и принимает все возможные
                                меры, исключающие доступ к персональным данным неуполномоченных лиц.
                            </div>
                            <div>10.2 Персональные данные Пользователя никогда, ни при каких условиях не будут переданы
                                третьим лицам, за исключением случаев, связанных с исполнением действующего
                                законодательства либо в случае, если субъектом персональных данных дано согласие
                                Оператору на передачу данных третьему лицу для исполнения обязательств по
                                гражданско-правовому договору.
                            </div>
                            <div>10.3 В случае выявления неточностей в персональных данных, Пользователь может
                                актуализировать их самостоятельно, путем направления Оператору уведомление на адрес
                                электронной почты Оператора support@imctech.ru с пометкой «Актуализация персональных
                                данных».
                            </div>
                            <div>10.4 Срок обработки персональных данных определяется достижением целей, для которых
                                были собраны персональные данные, если иной срок не предусмотрен договором или
                                действующим законодательством.
                            </div>
                            <div>Пользователь может в любой момент отозвать свое согласие на обработку персональных
                                данных, направив Оператору уведомление посредством электронной почты на электронный
                                адрес Оператора support@imctech.ru с пометкой «Отзыв согласия на обработку персональных
                                данных».
                            </div>
                            <div>10.5 Вся информация, которая собирается сторонними сервисами, в том числе платежными
                                системами, средствами связи и другими поставщиками услуг, хранится и обрабатывается
                                указанными лицами (Операторами) в соответствии с их Пользовательским соглашением и
                                Политикой конфиденциальности. Субъект персональных данных и/или Пользователь обязан
                                самостоятельно своевременно ознакомиться с указанными документами. Оператор не несет
                                ответственность за действия третьих лиц, в том числе указанных в настоящем пункте
                                поставщиков услуг.
                            </div>
                            <div>10.6 Установленные субъектом персональных данных запреты на передачу (кроме
                                предоставления доступа), а также на обработку или условия обработки (кроме получения
                                доступа) персональных данных, разрешенных для распространения, не действуют в случаях
                                обработки персональных данных в государственных, общественных и иных публичных
                                интересах, определенных законодательством РФ.
                            </div>
                            <div>10.7 Оператор при обработке персональных данных обеспечивает конфиденциальность
                                персональных данных.
                            </div>
                            <div>10.8 Оператор осуществляет хранение персональных данных в форме, позволяющей определить
                                субъекта персональных данных, не дольше, чем этого требуют цели обработки персональных
                                данных, если срок хранения персональных данных не установлен федеральным законом,
                                договором, стороной которого, выгодоприобретателем или поручителем по которому является
                                субъект персональных данных.
                            </div>
                            <div>10.9 Условием прекращения обработки персональных данных может являться достижение целей
                                обработки персональных данных, истечение срока действия согласия субъекта персональных
                                данных или отзыв согласия субъектом персональных данных, а также выявление неправомерной
                                обработки персональных данных.
                            </div>
                        </div>
                        <p>

                        <div><strong>11 Перечень действий, производимых Оператором с полученными персональными
                                данными</strong></div>
                        <div style="padding-left: 0.8rem">
                            <div>11.1 Оператор осуществляет сбор, запись, систематизацию, накопление, хранение,
                                уточнение (обновление, изменение), извлечение, использование, передачу (распространение,
                                предоставление, доступ), обезличивание, блокирование, удаление и уничтожение
                                персональных данных.
                            </div>
                            <div>11.2 Оператор осуществляет автоматизированную обработку персональных данных с
                                получением и/или передачей полученной информации по информационно-телекоммуникационным
                                сетям или без таковой.
                            </div>
                        </div>
                        <p>

                        <div><strong>12 Трансграничная передача персональных данных</strong></div>
                        <div style="padding-left: 0.8rem">
                            <div>12.1 Оператор до начала осуществления трансграничной передачи персональных данных
                                обязан убедиться в том, что иностранным государством, на территорию которого
                                предполагается осуществлять передачу персональных данных, обеспечивается надежная защита
                                прав субъектов персональных данных.
                            </div>
                            <div>12.2 Трансграничная передача персональных данных на территории иностранных государств,
                                не отвечающих вышеуказанным требованиям, может осуществляться только в случае наличия
                                согласия в письменной форме субъекта персональных данных на трансграничную передачу его
                                персональных данных и/или исполнения договора, стороной которого является субъект
                                персональных данных.
                            </div>
                        </div>
                        <p>

                        <div><strong>13 Конфиденциальность персональных данных</strong></div>
                        <div style="padding-left: 0.8rem">
                            <div>Оператор и иные лица, получившие доступ к персональным данным, обязаны не раскрывать
                                третьим лицам и не распространять персональные данные без согласия субъекта персональных
                                данных, если иное не предусмотрено федеральным законом.
                            </div>
                        </div>
                        <p>

                        <div><strong>14 Заключительные положения</strong></div>
                        <div style="padding-left: 0.8rem">
                            <div>14.1 Пользователь может получить любые разъяснения по интересующим вопросам, касающимся
                                обработки его персональных данных, обратившись к Оператору с помощью электронной почты
                                support@imctech.ru.
                            </div>
                            <div>14.2 В данном документе будут отражены любые изменения политики обработки персональных
                                данных Оператором. Политика действует бессрочно до замены ее новой версией.
                            </div>
                            <div>14.3 Актуальная версия Политики в свободном доступе расположена в сети Интернет по
                                адресу https://imctech.ru/privacy.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
