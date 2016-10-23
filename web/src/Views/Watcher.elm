module Views.Watcher exposing (..)

import Html as H exposing (Html)
import Html.Attributes as A
import Watcher.Model as Watcher exposing (..)


view : Watcher.State -> Html msg
view state =
    H.div []
        [ addDebtor
        , showDebtors state
        ]


addDebtor : Html msg
addDebtor =
    H.section [ A.class "add-debtor form-s" ]
        [ H.h3 [] [ H.text "Add New Debtor" ]
        , H.input [ A.type' "text", A.placeholder "First Name" ] []
        , H.input [ A.type' "text", A.placeholder "Last Name" ] []
        , H.input [ A.type' "date", A.placeholder "Birth Date" ] []
        , H.input [ A.type' "text", A.placeholder "CNP" ] []
        , H.button [ A.class "submit" ] [ H.text "Add Debtor" ]
        ]


showDebtors : Watcher.State -> Html msg
showDebtors { debtors } =
    H.section [ A.class "debtors-table" ]
        [ H.h2 [] [ H.text "Debtors" ]
        , H.table []
            [ H.thead []
                [ H.tr []
                    [ H.th [] [ H.text "First Name" ]
                    , H.th [] [ H.text "Last Name" ]
                    , H.th [] [ H.text "Birth Date" ]
                    , H.th [] [ H.text "CNP" ]
                    , H.th [] [ H.text "Total Debt" ]
                    , H.th [] [ H.text "" ]
                    ]
                ]
            , H.tbody [] (debtors |> List.map showDebtor)
            ]
        ]


showDebtor : Debtor -> Html msg
showDebtor { firstName, lastName, birthDate, birthPlace, cnp, debts } =
    let
        totalDebt =
            debts |> List.map .amount |> List.sum |> toString
    in
        H.tr []
            [ H.td [] [ H.text firstName ]
            , H.td [] [ H.text lastName ]
            , H.td [] [ H.text birthDate ]
            , H.td [] [ H.text cnp ]
            , H.td [] [ H.text <| totalDebt ++ " RON" ]
            , H.td [] [ H.button [] [ H.text "Edit" ] ]
            ]
