# TAItter
Twitteri paisti yksjuttu

-delay hakuun

# lautin pyynnöt:

-paksummat postaukset

# mitä pitäs vie tehä:

-Käyttäjillä on oletusnäkymä, jossa näytetään sovellukseen tehtyjä postauksia. Näkymässä näytetään postauksia seuraavasti

- Postaukset, joissa on jokin käyttäjän seuraama #aihetunniste

-Käyttäjällä on näkymä, jossa hän voi tarkastella, lisätä ja poistaa seurattuja #aihetunnisteita ja tykättyjä @käyttäjiä

- tän vois tehä silleen et filteroi ja näyttää käyttäjänäkymäs seuratut/tykätyt käyttäjät
- seuratut aihetunnisteet vois vaa filteroida postauksis ja sit niit klikkaamal vois jättää seuraamat aiheita

-Käyttäjä voi hakea postauksia #aihetunnisteen tai @käyttäjänimen perusteella

# Juhanin ongelmat

-voi lähettää toisen nimis postei vaihtamal id inspectoris


SELECT post_hashtags.post_id, post_hashtags.hashtag_id, hashtags.tag FROM `post_hashtags`
JOIN user_hashtags
ON user_hashtags.hashtag_id = post_hashtags.hashtag_id
JOIN hashtags
ON hashtags.hashtag_id = post_hashtags.hashtag_id
WHERE post_id = 66;

Valitaan postin x tagit
Valitaan tägeistä ne, joita käyttäjä y seuraa
Haetaan seurattujen tägien teksti

SELECT post_hashtags.post_id, post_hashtags.hashtag_id, hashtags.tag 
FROM post_hashtags
JOIN user_hashtags ON user_hashtags.hashtag_id = post_hashtags.hashtag_id
JOIN hashtags ON hashtags.hashtag_id = post_hashtags.hashtag_id
WHERE post_hashtags.post_id = :post_id
AND user_hashtags.user_id = :user_id;