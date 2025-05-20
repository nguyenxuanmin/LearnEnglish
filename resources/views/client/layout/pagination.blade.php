@if ($paginator->hasPages())
    <div class="pagination">
        @if (!$paginator->onFirstPage())
            <a href="{{$elements[0][1]}}"><i class="fa-solid fa-angles-left"></i></a>
        @endif
        @foreach ($elements as $element)
            @if (is_array($element))
                @php
                    $fromPage = 1;
                    $toPage = count($elements[0]);
                    if(count($elements[0]) > 6){
                        if ((count($elements[0]) - $paginator->currentPage()) < 3) {
                            $calToPage = count($elements[0]) - $paginator->currentPage();
                            $callFromPage = 3;
                        }else{
                            $calToPage = 3;
                            $callFromPage = count($elements[0]) - $paginator->currentPage();
                        }
                        $fromPage = $paginator->currentPage() - $callFromPage;
                        $toPage = $paginator->currentPage() + $calToPage;
                    }
                @endphp
                @for ($i = $fromPage; $i <= $toPage; $i++)
                    @if ($i == $paginator->currentPage())
                        <a href="{{$element[$i]}}" class="active">{{$i}}</a>
                    @else
                        <a href="{{$element[$i]}}">{{$i}}</a>
                    @endif
                @endfor
            @endif
        @endforeach
        @if ($paginator->hasMorePages())
            <a href="{{$elements[0][count($elements[0])]}}"><i class="fa-solid fa-angles-right"></i></a>
        @endif
    </div>
@endif