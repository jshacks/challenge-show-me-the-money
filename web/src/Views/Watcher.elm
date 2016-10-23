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


debtorDetails =
    H.section
        [ A.class "debtor-view" ]
        [ H.h2 [] [ H.text "Debtor: Sile" ]
        , H.article [ A.class "debtor-info" ]
            [ H.h3 [] [ H.text "Personal Details" ]
            , H.p [] [ H.label [] [ H.text "First Name: " ], H.span [] [ H.text "<<fname>>" ] ]
            , H.p [] [ H.label [] [ H.text "Last Name: " ], H.span [] [ H.text "<<L name>>" ] ]
            , H.p [] [ H.label [] [ H.text "Birth Date: " ], H.span [] [ H.text "<<birth date>>" ] ]
            , H.p [] [ H.label [] [ H.text "CNP: " ], H.span [] [ H.text "<<cnp>>" ] ]
            , H.p [] [ H.label [] [ H.text "Total Debt: " ], H.span [] [ H.text "<<total debt>>" ] ]
            , H.button [] [ H.text "Edit Personal Details" ]
            ]
        , H.article [ A.class "add-debt form-s" ]
            [ H.h3 [] [ H.text "Add New Debt for Sile" ]
            , H.input [ A.type' "text", A.placeholder "Amount" ] []
            , H.textarea [ A.placeholder "Reason" ] []
            , H.button [ A.class "submit" ] [ H.text "Add Debt" ]
            ]
        ]


debtsList =
    H.section
        [ A.class "debts-list" ]
        [ H.h3 [] [ H.text "Incurred Debts" ]
        , H.article [ A.class "debts" ]
            [ H.p [] [ H.label [] [ H.text "Amount: " ], H.span [] [ H.text "514851 lei" ] ]
            , H.p [] [ H.label [] [ H.text "Reason " ], H.span [] [ H.text "Lorem ipsum dummy text" ] ]
            , H.button [] [ H.text "Edit Debt" ]
            ]
        , H.article [ A.class "debts" ]
            [ H.p [] [ H.label [] [ H.text "Amount: " ], H.span [] [ H.text "514851 lei" ] ]
            , H.p [] [ H.label [] [ H.text "Reason " ], H.span [] [ H.text "Lorem ipsum dummy text" ] ]
            , H.button [] [ H.text "Edit Debt" ]
            ]
        , H.article [ A.class "debts" ]
            [ H.p [] [ H.label [] [ H.text "Amount: " ], H.span [] [ H.text "514851 lei" ] ]
            , H.p [] [ H.label [] [ H.text "Reason " ], H.span [] [ H.text "Lorem ipsum dummy text" ] ]
            , H.button [] [ H.text "Edit Debt" ]
            ]
        , H.article [ A.class "debts" ]
            [ H.p [] [ H.label [] [ H.text "Amount: " ], H.span [] [ H.text "514851 lei" ] ]
            , H.p [] [ H.label [] [ H.text "Reason " ], H.span [] [ H.text "Lorem ipsum dummy text" ] ]
            , H.button [] [ H.text "Edit / Update" ]
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
