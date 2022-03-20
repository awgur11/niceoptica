@extends('site.base')

@section('content')
<style type="text/css">
	.add-bg{
		position: relative;
	}
	.add-bg:before{
		position: absolute;
		content: "";
		width: 100%;
		height: 100%;
		background: #F1F4FF;
		left: -300px;
		z-index: -1;

	}
	.left-blue-line-block{
		border: 1px solid #DCDCDC;
		border-left: 4px solid #2C50F2;;
		padding: 40px;
		margin-top: 32px;
	}
	.lbl-title{
		font-family: Nunito Sans;
        font-size: 24px;
        font-style: normal;
        font-weight: 400;
        line-height: 29px;
        margin-bottom: 16px;
	}
	.lbl-text-block ul{
		padding-left: 15px;
	}
	.lbl-icon-block{
		width: 64px;
		height: 64px;
		text-align: center;
		background: #f1f4ff;
		font-size: 24px;
		padding: 20px;
		color: #2C50F2;
	}
	.lbl-icon-block-img{
		padding: 5px;
		width: 64px;
		height: 64px;
		text-align: center;
		background: #f1f4ff;
	}
	.lbl-icon-block-img img{
		width: 100%;
	}
</style>
<div class="container-fluid" style="">
	<div class="row mb-3">
		<div class="col-12">
			@include('layouts.site.path-block')
		</div>
	</div>
</div>
<div class="container-fluid p-0" style="overflow: hidden;">
	<div class="container">
	    <div class="row">
	    	<div class="col-12 page-content">
	    		<h2 class="page-title">
	    			Доставка
	    		</h2>
	    		<p class="my-3">
	    			Интернет-магазин контактных линз МКЛ осуществляет доставку товаров, как по г. Киеву, так и по всей Украине.
	    		</p>

	    		<div class="left-blue-line-block row">
	    			<div class="col-md-2 d-none d-md-block p-2">
	    				<div class="lbl-icon-block">
	    					<i class="icon-Suitcase">&nbsp;</i>
	    				</div>
	    			</div>
    				<div class="lbl-text-block col-10">
    					<div class="lbl-title">Самовывоз</div>
    					<ul>
    						<li>Вы можете самостоятельно забрать ваш заказ в нашем магазине "Оптика МКЛ", который находится по адресу: г. Киев, Е.Сверстюка, 6 (м. Левобережная, ЖК "Галактика").</li>
    						<li>К оплате принимаются как наличные, так и любые банковские платежные карты.</li>
    						<li>Наши контакты, время работы и карту проезда можно посмотреть здесь</li>
    					</ul>
    				</div>
    			</div>

    			<div class="left-blue-line-block row">
	    			<div class="col-md-2 d-none d-md-block p-2">
	    				<div class="lbl-icon-block">
	    					<i class="icon-Box-Alt">&nbsp;</i>
	    				</div>
	    			</div>
    				<div class="lbl-text-block col-10">
    					<div class="lbl-title">Курьером</div>
    					<ul>
    						<li>По Киеву БЕСПЛАТНО при стоимости покупки свыше 500 грн. (доставка осуществляется пешими курьерами, срок доставки 1-2 дня). - <b>На период карантина эта услуга не доступна.</b></li>
    						<li>При стоимости покупки до 500 грн. стоимость курьерской доставки - 50 грн.</li>
    						<li>Адресная доставка курьером "Нова Пошта" по всем городам Украины составляет – 50 грн., срок доставки 1-2 дня.</li>
    						<li>Стоимость доставки очковых оправ и солнцезащитных очков для примерки - 50грн.</li>
    					</ul>
    				</div>
    			</div>

    			<div class="left-blue-line-block row">
	    			<div class="col-md-2 d-none d-md-block p-2">
	    				<div class="lbl-icon-block-img">
	    					<img src="/images/nova-poshta.png" alt="">
	    				</div>
	    			</div>
    				<div class="lbl-text-block col-10">
    					<div class="lbl-title">Через ближайшее отделение «Нова пошта»</div>
    					<ul>
    						<li><b>БЕСПЛАТНО</b> при стоимости покупки свыше 500 гривен в любое указанное Вами отделение "Нова пошта".</li>
    						<li>Время доставки сервисом доставки "Нова пошта" составляет 1-2 дня.</li>
    						<li>Время доставки сервисом доставки "Нова пошта" составляет 1-2 дня.</li>
    						<li><b>ОБРАЩАЕМ ВАШЕ ВНИМАНИЕ:</b> срок хранения посылок на отделении "Нова Пошта" - 4 дня, на 5-й день посылка возвращается обратно в магазин!</li>
    					</ul>
    				</div>
    			</div>

    			<div class="left-blue-line-block row">
	    			<div class="col-md-2 d-none d-md-block p-2">
	    				<div class="lbl-icon-block-img">
	    					<img src="/images/ukrposhta.png" alt="">
	    				</div>
	    			</div>
    				<div class="lbl-text-block col-10">
    					<div class="lbl-title">Через ближайшее отделение «Укрпочты»</div>
    					<ul>
    						<li><b>БЕСПЛАТНО</b> при стоимости покупки свыше 500 грн. в любое указанное Вами отделение «Укрпочты».</li>
    						<li>Если сумма заказ меньше 500 грн., то стоимость доставки - 50 грн.</li>
    						<li>Заказы по "Укрпочте" отправляются при условии полной предоплаты.</li>
    						<li>Время доставки «Укрпочтой» составляет 3-8 дней.</li>
    					</ul>
    				</div>
    			</div>

    			<h2 class="page-title mt-5">
	    			Оплата
	    		</h2>
	    		<p class="my-3">
	    			Оплата товара возможна как наличными, так и безналичным способами.
	    		</p>

	    		<div class="left-blue-line-block row">
	    			<div class="col-md-2 d-none d-md-block p-2">
	    				<div class="lbl-icon-block">
	    					<i class="icon-Money---Alt">&nbsp;</i>
	    				</div>
	    			</div>
    				<div class="lbl-text-block col-10">
    					<div class="lbl-title">Наличными при получении</div>
    					<ul>
    						<li>Наличными курьеру при передаче товара.</li>
    						<li>Наложенный платеж в сервисе доставки</li>
    						<li><b>В сервисе доставки "Нова пошта" Вы оплачиваете только сумму Вашего заказа, все транспортные расходы и обратную доставку денег мы берем на себя.</b></li>
    					</ul>
    				</div>
    			</div>

    			<div class="left-blue-line-block row">
	    			<div class="col-md-2 d-none d-md-block p-2">
	    				<div class="lbl-icon-block-img">
	    					<img src="/images/privat24.png" alt="">
	    				</div>
	    			</div>
    				<div class="lbl-text-block col-10">
    					<div class="lbl-title">Приват24</div>
    					<ul>
    						<li>При оформлении заказа на сайте выберите способ оплаты «Приват 24» и далее пошагово следуйте инструкции.</li>
    						<li>Если вы сделали заказ по телефону и пожелаете оплатить его в системе «Приват 24», тогда менеджер нашего интернет-магазина вышлет вам sms-сообщение с реквизитами нашей карты «Приват».</li>
    					</ul>
    				</div>
    			</div>

    			<div class="left-blue-line-block row">
	    			<div class="col-md-2 d-none d-md-block p-2">
	    				<div class="lbl-icon-block">
	    					<i class="icon-Credit-Card">&nbsp;</i>
	    				</div>
	    			</div>
    				<div class="lbl-text-block col-10">
    					<div class="lbl-title">Банковской платежной картой</div>
    					<ul>
    						<li>Принимаются любые банковские платежные карты при оплате товаров в салоне-оптики МКЛ.</li>
    						<li>На нашем сайте возможна безопасная оплата банковскими картами VISA и MasterCard через систему LiqPay. Оплатить заказ можно прямо при его оформлении на сайте следуя пошаговым инструкциям.</li>
    					</ul>
    				</div>
    			</div>

    			<div class="left-blue-line-block row">
	    			<div class="col-md-2 d-none d-md-block p-2">
	    				<div class="lbl-icon-block">
	    					<i class="icon-File">&nbsp;</i>
	    				</div>
	    			</div>
    				<div class="lbl-text-block col-10">
    					<div class="lbl-title">Безналичный расчет</div>
    					<ul>
    						<li>Оплата на безналичный расчетный счет. Для этого на указанный Вами e-mail будет выслана счет-фактура, которую вы сможете оплатить со своего расчетного счета или в ближайшем отделении любого банка.</li>
    					</ul>
    				</div>
    			</div>
    		</div>
	    </div>
    </div>
</div>

@endsection