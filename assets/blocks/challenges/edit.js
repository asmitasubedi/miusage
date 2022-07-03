import { useBlockProps } from "@wordpress/block-editor";
import { useEffect, useState } from "@wordpress/element";
import { Disabled } from "@wordpress/components";
import BlockInspector from "./inspector";
import { __ } from "@wordpress/i18n";

export default (props) => {
	const {
		attributes,
		setAttributes,
		className,
		isSelected,
		clientId,
	} = props;

	const {
		
		showTitle,
		
	} = attributes;

	const [recipes, setRecipes] = useState([]);
	const blockProps = useBlockProps();

	useEffect(() => {
		const fetchRecipes = async () => {
            const response = await fetch(`${miusage.api_url}/recipes`);
            const data = await response.json();
            setRecipes(data);
        }
        // fetchRecipes();
	}, [null]);

	// useEffect(() => {
	// 	//Get recipe posts from ajax call
	// 	const getRecipePosts = async (attributes) => {
	// 		const body = new FormData();
	// 		body.append("attributes", JSON.stringify(attributes));
	// 		body.append("action", "dr_widgets_blocks_get_recipe_posts");
	// 		const response = await fetch(ajaxurl, {
	// 			method: "POST",
	// 			body,
	// 		});
	// 		const json = await response.json();
	// 		setRecipes(json.data);
	// 	};
	// 	getRecipePosts(attributes);
	// }, [
	// 	postsPerPage,
	// ]);

	return (
		<div className={className} {...blockProps}>
			{/* <BlockInspector
				{...{ attributes, setAttributes, className, isSelected }}
			/> */}
			{/* {recipes && recipes?.length > 0 && (
				<div
					id={`drwb-recipe-posts-carousel-style-${clientId}`}
					className={`drwb-recipe-posts-carousel-wrapper ${className}`}
				>
					<Disabled>
						<div className="dr-widget">
							<div
								className={`dr-widgetBlock_recipe-carousel carousel_${layout}`}
							>
								<div
									style={{ "--column-gap": slideItemGap }}
									className={`dr-widgetBlock_row nowrap-${perSlide}-lg nowrap-${perSlideTablet}-md nowrap-${perSlideMobile} dr_columns-${perSlide}-lg dr_columns-${perSlideTablet}-md dr_columns-${perSlideMobile}`}
								>
									{recipes?.map((recipe, index) => {
										return (
											<div
												className="dr_column"
												key={index}
											>
												<div
													className={`dr-widgetBlock_recipe-post`}
												>
													{showFeatureImage ==
														"yes" && (
														<FeaturedImage
															recipe={recipe}
														/>
													)}

													<div className="dr-widgetBlock_content-wrap">
														{layout ===
															"layout-3" &&
															recipe.recipe_keys
																.length > 0 &&
															showRecipeKeys ==
																"yes" && (
																<RecipeKeys
																	recipe={
																		recipe
																	}
																/>
															)}

														{showTitle ===
															"yes" && (
															<TagTitle className="dr_title">
																<a
																	href={
																		recipe.permalink
																	}
																>
																	{decodeEntities(
																		recipe.title
																	)}
																</a>
															</TagTitle>
														)}

														<div className="dr_meta-content">
															<div className="dr_meta-items">
																{recipe?.total_time &&
																	showTotalTime ==
																		"yes" && (
																		<span className="dr_meta-item dr_meta-duration">
																			{
																				recipe.total_time
																			}
																		</span>
																	)}
																{recipe?.difficulty_level &&
																	showDifficulty ==
																		"yes" && (
																		<span className="dr_meta-item dr_meta-level">
																			{
																				recipe.difficulty_level
																			}
																		</span>
																	)}
															</div>
														</div>

														{(layout ===
															"layout-1" ||
															layout ===
																"layout-2") &&
															recipe.recipe_keys
																.length > 0 &&
															showRecipeKeys ==
																"yes" && (
																<RecipeKeys
																	recipe={
																		recipe
																	}
																/>
															)}
													</div>
												</div>
											</div>
										);
									})}
								</div>
								<div
									className={`dr-recipe_carousel-navigation ${nav_class}`}
								>
									<div className="swiper-button-next dr_swiper-next"></div>
									<div className="swiper-button-prev dr_swiper-prev"></div>
								</div>
							</div>
						</div>
					</Disabled>
				</div>
			)} */}
			{recipes.length === 0 && (
				<p>
					{__(
						"Please check the widget settings and make sure you have selected a valid taxonomy and term.",
						"dr-widgets-blocks"
					)}
				</p>
			)}
		</div>
	);
};